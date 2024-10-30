<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

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

    public function sendNotification($token, $title, $data, $type)
    {

        if ($type == 'android') {
            $res = fcm()
                ->to(["cytJPQaUQTyDvjjlQHXdDm:APA91bHMQSxrzgjvLlPgVLITHu7OlfmM2gSsE77qOgZNpW8pbJpUrqjnBThJvhn1UhDZkHfrgbSCMNu7juapvolS_s85nIN5U2Q9Y_YKExNUrErYoofT2SO36ZcnMRrSmJkypLLr9wsi","eApWSdq7Q7mENx2bEQPL62:APA91bEbJ7HYv7n0N8BVERCAE8uLrt2Z8k9rNYLX0b1Hj7VMJj-lcLeC7SOaCiePZHZU_VXyLE9r3RunTagzLfCTtAs4ss8jte-Zxhr2xSvCbjRJUI15eomJtNGC5dfed_deBMMtETIo"]) // $token must an array
                ->priority('high')
                ->data([
                    'title' => $title,
                    'body' => $data,
                    'status' => '1',
                    'sound' => 'default',
                ])
                ->send();

        } else {
            $res = fcm()
                ->to($token) // $token must an array
                ->priority('high')
                ->data([
                    'title' => $title,
                    'body' => $data,
                    'status' => '1',
                    'sound' => 'default',
                    'alert' => [
                    'sound' => 'default'
                ]
            ])->notification([
                'title' => $title,
                'body' => $data['message'],
                'status' => '1',
                'mutable_content' => true,
                'badge' => '1',
                'sound' => 'default'
            ])
            ->send();
        }
        \Log::info([$res]);
        return $res;

    }



}
