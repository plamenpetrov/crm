<?php

use Illuminate\Pagination\Paginator as Paginator;

//namespace App\Http\Controllers;

class ApiController extends BaseController {

    protected $statusCode = 200;

    /**
     * 2.. statuses
     */
    const HTTP_CREATED = 201;
    const HTTP_CHANGES_CANCELED = 202;
    const HTTP_DELETED = 204;

    /**
     * 3.. statuses
     */
    const HTTP_REDIRECT = 302;

    /**
     * 4.. statuses
     */
    const HTTP_NOT_FOUND = 404;
    const HTTP_NOT_ACCEPTABLE = 406;
    const HTTP_INTERNAL_SERVER_ERROR = 500;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_QUERY_FAILED = 499;

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respond($data, $message = null, $headers = []) {
        return ResponseApi::respond($data, $this->statusCode, $message, $headers);
    }

    /**
     * Response with error  
     * @param type $message
     * @return type
     */
    private function respondWithError($message) {
        return $this->respond([], $message);
    }

    /**
     * Response with error saying that the user is not authorized
     * @param type $message
     * @return type
     */
    public function respondUnauthorized($message = 'Not logged!') {
        return $this->setStatusCode(self::HTTP_UNAUTHORIZED)->respondWithError($message);
    }

    /**
     * Response with error when a resource is not found
     * @param type $message
     * @return type
     */
    public function respondNotFound($message = 'Not found!') {
        return $this->setStatusCode(self::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * Response with error 
     * @param type $message
     * @return type
     */
    public function respondNotAceptable($message = 'Not acceptable!') {
        return $this->setStatusCode(self::HTTP_NOT_ACCEPTABLE)->respondWithError($message);
    }

    /**
     * Response with error saying that the query is failed
     * @param type $message
     * @return type
     */
    public function respondQueryFailed($message = 'Error in db query!') {
        return $this->setStatusCode(self::HTTP_QUERY_FAILED)->respondWithError($message);
    }

    /**
     * Respond with error when there is internal server error
     * @param type $message
     * @return type
     */
    public function respondInternalError($message = 'Internal error!') {
        return $this->setStatusCode(self::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Respond wich success, when a resource is created/updated
     * @param type $message
     * @return type
     */
    public function respondCreated($message = 'Created!', $data = null) {
        return $this->setStatusCode(self::HTTP_CREATED)->respond($data, $message);
    }

    /**
     * Respond with pagination
     * @param Paginator $items
     * @param type $data
     * @return type
     */
    public function respondWithPagination(Paginator $items, $data) {
        $data = array_merge($data, [
            'paginator' => [
                'total_count' => $items->getTotal(),
                'total_pages' => ceil($items->getTotal() / $items->getPerPage()),
                'current_page' => $items->getCurrentPage(),
                'limit' => $items->getPerPage()
            ]
        ]);
        return $this->respond($data);
    }

    /**
     * Respon with success when a resource is deleted
     * @param type $message
     * @return type
     */
    public function respondDeleted($message = 'Deleted') {
        return $this->setStatusCode(self::HTTP_DELETED)->respond([], $message);
    }

    /**
     * Respond with success when an opened form has been discarded(canceled)
     * @param type $message
     * @return type
     */
    public function respondChangesDiscarded($message = 'Canceled') {
        return $this->setStatusCode(self::HTTP_CHANGES_CANCELED)->respond([], $message);
    }

    /**
     * Reespond with form data and values
     * @param type $formValues
     * @param type $formData
     * @return type
     */
    public function respondForm($formValues, $formData) {
        return $this->respond([
            'form-values' => $formValues,
            'form-data' => $formData
        ]);
    }

}
