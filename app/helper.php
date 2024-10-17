<?php

namespace App;

use App\Models\Reply;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class helper
{
    public function saveFile(Request $request, Ticket $ticket = null, Reply $reply = null)
    {
        $uploadFileFormat = Setting::where('key', 'upload_file_format')->value('value');
        $uploadFileSize = (int) Setting::where('key', 'upload_file_size')->value('value');
        $uploadFilePath = Setting::where('key', 'upload_file_path')->value('value');

        $allowedFormats = explode('|', $uploadFileFormat);
        $allowedFormats = array_map('trim', $allowedFormats);

        $fileNumber = 1;
        $savedFilesPaths = [];

        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:' . implode(',', $allowedFormats) . '|max:' . $uploadFileSize,
        ]);

        if ($request->hasFile('files')) {

            foreach ($request->file('files') as $file) {

                $extension = $file->getClientOriginalExtension();

                if($ticket){
                    $newFileName = $ticket->SID . '-FILE-' . $fileNumber . '.' . $extension;
                }

                elseif($reply){
                    $newFileName = $reply->SID . '-FILE-' . $fileNumber . '.' . $extension;
                }

                $filePath = $file->storeAs($uploadFilePath, $newFileName, 'public');


                $savedFilesPaths[] = $filePath;

                $fileNumber++;
            }

            return $savedFilesPaths; // Return an array of file paths
        }

        return [];
    }

    public function generateUserSID(){
        do{
            $sid = Str::random(20);

        }while(User::where('SID', $sid)->exists());
        return $sid;
    }

    public function generateTicketSID(){
        do{
            $sid = Str::random(20);

        }while(Ticket::where('SID', $sid)->exists());
        return $sid;
    }

    public function generateReplySID(){
        do{
            $sid = Str::random(20);

        }while(Reply::where('SID', $sid)->exists());
        return $sid;
    }

    public function returnFiles($SID, array $filesPaths)
    {
        $urls = [];


        $fileNumber = 1;
        foreach ($filesPaths as $filePath) {
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            $fileName = $SID . '-FILE-' . $fileNumber . '.' . $extension;

            $url = Storage::temporaryUrl('uploads/' . $fileName, now()->addMinutes(10));

            $urls []=  $url;

            $fileNumber++;

        }
        return $urls;
    }

    public function countTotalTickets()
    {
        return Ticket::count();

    }
    public function isTicketPending($replies)
    {


        foreach ($replies as $reply){
            if($reply['sender']== 'admin'){
                return false;
            }
        }
        return true;

    }

//foreach ($ticket['replies'] as $reply) {
//if ($this->isTicketPending($ticket) && $ticket['status']->value != 'closed') {
    public function countPendingTickets()
    {
        $tickets = Ticket::all()->load('replies');
        $count =0;

        foreach($tickets as $ticket){

            if($this->isTicketPending($ticket['replies']) && $ticket['status']->value != 'closed'){
                $count++;
            }
        }

        return $count;

    }

    public function countClosedTickets()
    {
        $tickets = Ticket::all();
        $count =0;
        foreach($tickets as $ticket){
            if($ticket['status']->value == 'closed'){
                $count++;
            }
        }

        return $count;

    }

    public function checkRole($user_id){

        $user = User::where('id', $user_id)->first();
        if($user){
            return $user->role->role_name;
        }
        else "User not found";
    }
}
