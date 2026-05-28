<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Http\Requests\AddRoomRequest;

class RoomController extends Controller
{

    public function list(Request $request)
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }


    public function add(AddRoomRequest $request)
    {
        $validated=$request->validated();
        $room = Room::create($validated);
        return response()->json($room);
    }

    public function delete($id)
    {
        $room = Room::findOrFail($id);

        $room->delete();
        return response()->json([
            'message' => 'Комната удалена'
        ]);
    }
}