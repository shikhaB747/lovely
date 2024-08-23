<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Helpers\NotificationHelper;
use App\Models\{Chat, User};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Validator};
use DB;

class ChatController extends Controller
{
    public function storeChat(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'partner_id'    => 'required',
            'message'       => 'required',
            'message_type'  => 'required',  // 1-Text, 2-Images, 3-Audio
            'chat_room'     => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $request['user_id'] = $user_id = $this->loggedInUser->id;
        $partner_id         = $request->partner_id;

        if ($request->message_type == '2' || $request->message_type == '3') {

            if ($request->hasFile('message')) {
                // Upload image
                $request['image'] = fileUpload($request->file('message'), 'chat_images');
            }
        }

        Chat::create($request->all());

        // === Notify to Partner ===

        $type           = "message";

        $title          =  "Message Received";
    
        $message        =  "You've received a new message! Check it out and keep the conversation flowing";
         
        $details        =  ['message' => $message, 'type' => $type, 'respected_id' => "$partner_id"];

        $partner        =  User::select('device_token')->find($partner_id);
    
        $statusNotify   =  NotificationHelper::sendNotification($partner->device_token, $title, $message, $details);
 
        NotificationHelper::saveNotification($user_id, $type, $title, $message, $partner_id);

        // ============================================================

        return response()->json([
            'status'  => true,
            'message' => 'success'
        ]);
    }

    public function readChat(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'chat_room'  =>  'required|exists:chats'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'message' => $validator->errors()->first()], 422);
        }

        $userId        =  $this->loggedInUser->id;

        $getBlockedIds =  User::where('id', $userId)->first('blocked_ids', 'not_for_me_ids');

        $allIds        =  explode(',', $getBlockedIds->blocked_ids);

        $chats         =  Chat::where('user_id', $userId)
            ->orWhere('partner_id', $userId)
            ->groupBy('chat_room')
            ->selectRaw('MAX(id) as latest_id')
            ->whereNotIn('partner_id', $allIds)
            ->whereNotIn('user_id', $allIds)
            ->get();

        if ($chats->isNotEmpty()) {

            $latestChatIds = $chats->pluck('latest_id');

            $latestChats   = Chat::select('id', 'user_id', 'message', 'partner_id', 'image', 'chat_room', 'message_type', 'created_at')
                ->whereIn('id', $latestChatIds)
                ->whereNotIn('partner_id', $allIds)
                ->whereNotIn('user_id', $allIds)
                ->orderBy('id', 'desc')
                ->get();

            $latestChats->map(function ($chats) use ($userId) {

                $otherUserId         = $chats->user_id === $userId ? $chats->partner_id : $chats->user_id;
 
                Chat::select('id')->where(['partner_id' => $userId, 'user_id' => $otherUserId, 'is_read' => 0, 'chat_room' => $chats->chat_room])->update(['is_read' => 1]);

                return $chats;
            });
        }


        // Chat::where(['user_id' => $userId,  'is_read' => 0, 'chat_room' => $chat_room])->update(['is_read' => 1]);

        return true;
    }

    public function chatList()
    {

        $userId        =  $this->loggedInUser->id;

        $getBlockedIds =  User::where('id', $userId)->first('blocked_ids', 'not_for_me_ids');

        $allIds        =  explode(',', $getBlockedIds->blocked_ids);

        $chats         =  Chat::where('user_id', $userId)
            ->orWhere('partner_id', $userId)
            ->groupBy('chat_room')
            ->selectRaw('MAX(id) as latest_id')
            ->whereNotIn('partner_id', $allIds)
            ->whereNotIn('user_id', $allIds)
            ->get();

        if ($chats->isNotEmpty()) {

            $latestChatIds = $chats->pluck('latest_id');

            $latestChats   = Chat::select('id', 'user_id', 'message', 'partner_id', 'image', 'chat_room', 'message_type', 'created_at')
                ->whereIn('id', $latestChatIds)
                ->whereNotIn('partner_id', $allIds)
                ->whereNotIn('user_id', $allIds)
                ->orderBy('id', 'desc')
                ->get();

            $formattedChats      = $latestChats->map(function ($chats) use ($userId) {

                $otherUserId         = $chats->user_id === $userId ? $chats->partner_id : $chats->user_id;

                $chats->user_id      = $userId;

                $chats->partner_id   = $otherUserId;

                $unreadCount         = Chat::select('id')->where(['partner_id' => $userId, 'user_id' => $otherUserId, 'is_read' => 0, 'chat_room' => $chats->chat_room])->count();

                $otherUser           = User::find($otherUserId);
                $chats->user_name    = $otherUser ? $otherUser->name : 'Unknown';
                $chats->profile      = $otherUser ? $otherUser->image_profile : 'Unknown';
                $chats->unreadCount  = $unreadCount;
                $chats->match        = $chats->match();

                return $chats;
            });

            return response()->json(['status' => true, 'message' => 'Chat List', 'data' => $formattedChats]);
        }
        return response()->json(['status' => false, 'message' => "No Chat List"]);
    }
}
