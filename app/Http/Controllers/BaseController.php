<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class BaseController extends Controller
{

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess($message = 'Done!', $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message
        ], $code);
    }

    /**
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithError($message = 'Failed!', $code = 500)
    {
        return Response::json([
            'success' => false,
            'message' => $message
        ], $code);
    }

    /**
     * @param array $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithData($data = [], $message = 'Done!', $code = 200)
    {
        return Response::json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param array $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondData($data = [], $code = 200)
    {
        return Response::json($data, $code);
    }

    /**
     * Get JSON data from request, and validate if it can be processed
     * JSON objects will be converted to arrays
     *
     * @return array[]
     * @throws CustomException
     */
    protected function getJson()
    {
        $json = Request::getContent();
        $data = json_decode($json, $assoc = true);
        if ($data === null) {
            throw new CustomException('No input data or malformed JSON received');
        }
        return $data;
    }

    /**
     * Get JSON data from request, and validate if it can be processed
     * JSON objects will be converted to arrays
     *
     * @return array[]
     * @throws \Exception
     */
    protected function getJsonParam($json)
    {
        //$json = Request::getContent();
        $data = json_decode($json, $assoc = true);
        if ($data === null) {
            throw new CustomException('No input data or malformed JSON received');
        }
        return $data;
    }

    public function sweetAlert($type = 'Message', $text = null, $title = 'Alert')
    {
        switch ($type) {
            case 'message':
                alert()->message($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'basic':
                alert()->basic($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'info':
                alert()->info($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'success':
                alert()->success($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'error':
                alert()->error($text, $title)->persistent('Close');
                break;
            case 'warning':
                alert()->warning($text, $title)->persistent('Close');
                break;
            default:
                break;
        }
    }

    protected function removeImage($image_path)
    {
        $path = public_path() . '/uploads/' . $image_path;  // Value is not URL but directory file path
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    public function uploadImageWithThumbnail(Request $request, $uploadFolderName, $inputFileName)
    {
        $validator = Validator::make($request->all(), [ //'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            $inputFileName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            $errors = $validator->messages()->all();
            return $this->respondWithError($errors[0], 401);
        }

        $uploadFolder = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
         $path = $uploadFolder.$uploadFolderName;
        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0777, true, true);
        }
        $originalImage = $request->file($inputFileName);
        $thumbnailImage = Image::make($originalImage);
        $createImageName = time() . '.' . $originalImage->getClientOriginalExtension();
        $originalPath = $uploadFolder . $uploadFolderName . DIRECTORY_SEPARATOR;
        $thumbnailImage->save($originalPath . $createImageName);
        return $this->respondWithData($uploadFolderName . '/' . $createImageName, 401);

    }
    public function uploadImageArrWithThumbnail(Request $request, $uploadFolderName, $inputFileName)
    {
        // $validator = Validator::make($request->all(), [ //'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     $inputFileName => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        // if ($validator->fails()) {
        //     $errors = $validator->messages()->all();
        //     return $this->respondWithError($errors[0], 401);
        // }
        $uploadFolder = public_path() . '/' . 'uploads' . '/';
        // $uploadFolderName = $moduletype. '/'.$moduletype.'_'.$reference_id;
        $path = $uploadFolder.$uploadFolderName;

        if (!\File::exists($path)) {
            \File::makeDirectory($path, 0777, true, true);
        }
        $imageArr = [];
        foreach ($request->$inputFileName as $key => $file) {
             $originalImage = $file;
            $uploadFolder = public_path() . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
            // $originalImage = $request->file($inputFileName);
            $thumbnailImage = Image::make($originalImage);
            $createImageName = time() .$key. '.' . $originalImage->getClientOriginalExtension();
            $originalPath = $uploadFolder . $uploadFolderName . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
            $thumbnailImage->save($originalPath . $createImageName);
            array_push($imageArr, $uploadFolderName . '/' . $createImageName);
        }
        return $this->respondWithData($imageArr, 401);

    }


    public function uploadImage($type = 'Message', $text = null, $title = 'Alert')
    {
        switch ($type) {
            case 'message':
                alert()->message($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'basic':
                alert()->basic($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'info':
                alert()->info($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'success':
                alert()->success($text, $title)->persistent('Close')->autoclose(3000);
                break;
            case 'error':
                alert()->error($text, $title)->persistent('Close');
                break;
            case 'warning':
                alert()->warning($text, $title)->persistent('Close');
                break;
            default:
                break;
        }
    }

    public function dateConvert($date)
    {
        $date = strtotime($date);
        $html = date('M d, Y', $date);
        return $html;
    }

    public function sendNotification(array $tokens, string $title, array $data, string $type)
{
    $chunks = array_chunk($tokens, 500); // Firebase allows a maximum of 500 tokens per request
    $responseReports = [];

 
    info(json_encode($tokens));
    info(json_encode($chunks));
     
    foreach ($chunks as $chunk) {
        try {
            $message = [
                'notification' => [
                    'title' => $title,
                    'body' => $data['message'],
                ],
                'data' => $data,
                'android' => [
                    'priority' => 'high',
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => $title,
                                'body' => $data['message'],
                            ],
                            'sound' => 'default',
                        ],
                    ],
                ],
            ];


            // Send notification using Firebase messaging service
            $response = app('firebase.messaging')->sendMulticast($tokens, $message);
            \Log::info("Notification sentt successfully", ['success_count' => $response->successes()->count()]);
            $responseReports[] = ['report' => $response->successes()->count()];

        } catch (\Exception $e) {
            \Log::error("Notification Error: " . $e->getMessage());
            $responseReports[] = ['error' => $e->getMessage()];
        }
    }

    return $responseReports;
}

}
