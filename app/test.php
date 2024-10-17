<?php
if ($request->hasFile('files')) {
foreach ($request->file('files') as $file) {
\Log::info('Processing file', ['file' => $file]);

$request->validate([
'files.*' => 'mimes:' . implode(',', $allowedFormats) . '|max:' . $uploadFileSize,
]);

$extension = $file->getClientOriginalExtension();
$newFileName = $ticket->SID . '-file' . $fileNumber . '.' . $extension;
$filePath = $file->storeAs($uploadFilePath, $newFileName, 'public');

$savedFilesPaths[] = $filePath;
$fileNumber++;
}
$filesPaths = implode(',', $savedFilesPaths);

return $filesPaths;
}
