<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function getAllTopics()
    {
        $topics = Topic::get()->toJson(JSON_PRETTY_PRINT);
        return response($topics, 200);
    }

    public function getTopic($id)
    {
        if (Topic::where('id', $id)->exists()) {
            $topic = Topic::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($topic, 200);
        } else {
            return response()->json([
                "message" => "Topic not found"
            ], 404);
        }
    }

    public function createTopic(Request $request)
    {
        //add validate
        $topic = new Topic;
        $topic->name = $request->name;
        $topic->description = $request->description;

        if ($_SERVER['SERVER_NAME'] == '127.0.0.1') {
            $url = "http://127.0.0.1:8000";
        } else {
            $url = $_SERVER['SERVER_NAME'];
        }

        $topic->link = $url . '/api/topic/' . str_replace(" ", "-", $request->name);
        $topic->slug = str_replace(" ", "-", $request->name);

        $topic->save();

        return response()->json([
            "message" => "Topic record created"
        ], 201);
    }

    public function updateTopic(Request $request, $id)
    {
        $topic = Topic::findOrFail($id);

        $topic->name = $request->name;
        $topic->description = $request->description;

        if ($_SERVER['SERVER_NAME'] == '127.0.0.1') {
            $url = "http://127.0.0.1:8000";
        } else {
            $url = $_SERVER['SERVER_NAME'];
        }

        $topic->link = $url . '/api/topic/' . str_replace(" ", "-", $request->name);
        $topic->slug = str_replace(" ", "-", $request->name);

        $topic->save();

        return response()->json([
            "message" => "records updated successfully"
        ], 200);
    }

    public function deleteTopic($id)
    {
        if (Topic::where('id', $id)->exists()) {
            $topic = Topic::find($id);
            $topic->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Topic not found"
            ], 404);
        }
    }

    public function search($name){
        return Topic::where('name','like','%'.$name.'%')->get();
    }
}
