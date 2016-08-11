<?php
    namespace App\Http\Requests;


    use Illuminate\Foundation\Http\FormRequest;
    use App\Utils\ResponseUtil;
    use Response;

    class APIRequest extends FormRequest{
        
        private $res;

        /**
         * Get the proper failed validation response for the request.
         *
         * @param array $errors
         *
         * @return \Symfony\Component\HttpFoundation\Response
         */
        public function response(array $errors)
        {
            $messages = implode(' ', array_flatten($errors));
            return response()->json(ResponseUtil::error_detail(1002,$messages));
        }

    }