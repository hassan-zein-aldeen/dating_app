<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers()
    {
        $gender = Auth::user()->gender;

        if ($gender == 'female') {
            $intrst_gender = 'male';
        } else {
            $intrst_gender = 'female';
        }

        $users = DB::table('users')->where('gender', $intrst_gender)->get();
        return response()->json([
            'status' => 'success',
            'users' => $users
        ]);
    }

    public function block(Request $request, $id)
    {
        $user_id = Auth::id();
        $blocked_user_id = $id;
        $blockCount = DB::table('blocks')
            ->where('blocker', Auth::id())
            ->where('blocked', $blocked_user_id)
            ->count();

        if ($blockCount > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'already blocked'
            ]);
        }

        DB::table('blocks')->insert([
            'blocker' => Auth::id(),
            'blocked' => $blocked_user_id,

        ]);


        return response()->json([
            'status' => 'success',
            'message' => 'User successfully blocked'
        ]);
    }


    public function unblock(Request $request, $id)
    {
        $user_id = Auth::id();
        $blocked = $id;
        $blockCount = DB::table('blocks')
            ->where('blocker', Auth::id())
            ->where('blocked', $blocked)
            ->count();

        if ($blockCount == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'user not blocked'
            ]);
        }

        DB::table('blocks')
            ->where('blocker', $user_id)
            ->where('blocked', $blocked)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user unblocked'
        ]);
    }

    public function like(Request $request, $id)
    {
        $user_id = Auth::id();
        $liked_user_id = $id;
        $likeCount = DB::table('likes')
            ->where('sender', Auth::id())
            ->where('receiver', $liked_user_id)
            ->count();

        if ($likeCount > 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'user already liked'
            ]);
        }

        DB::table('likes')->insert([
            'sender' => Auth::id(),
            'receiver' => $liked_user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'liked'
        ]);
    }


    public function unlike(Request $request, $id)
    {
        $user_id = Auth::id();
        $liked_user_id = $id;
        $likeCount = DB::table('likes')
            ->where('sender', $user_id)
            ->where('receiver', $liked_user_id)
            ->count();

        if ($likeCount == 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'already not liked'
            ]);
        }

        DB::table('likes')
            ->where('sender', $user_id)
            ->where('receiver', $liked_user_id)
            ->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'user unliked'
        ]);
    }

    public function filter(Request $request)
    {
        $location = $request->input('location');
        $query = DB::table('users');
        if ($location) {
            $query->where('location', $location);
        }
        $results = $query->get();

        return response()->json([
            'status' => 'success',
            'users' => $results
        ]);
    }

    public function profile(Request $request)
    {
        $user_id = Auth::id();
        $user_profile = DB::table('users')->where('id',$user_id)->get();
        return response()->json([
            'status' => 'success',
            'users' => $user_profile
        ]);
        return response()->json([
            'status' => 'error',
            'message' => "loading error"
        ]);
    }
}
