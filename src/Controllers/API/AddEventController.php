<?php

namespace Portal\Controllers\API;

use Portal\Abstracts\Controller;
use Portal\Validators\EventValidator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;
use Portal\Models\EventModel;
use Portal\Entities\EventEntity;

class AddEventController extends Controller
{
    private $eventModel;

    /**
     * AddEventController constructor
     *
     * @param EventModel $eventModel
     */
    public function __construct(EventModel $eventModel)
    {
        $this->eventModel = $eventModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $newEvent = $request->getParsedBody();
        $responseData = [
            'success' => false,
            'message' => 'Unexpected Error.',
            'data' => []
        ];
        $statusCode = 400;

        try {
            $newEvent['category'] = EventValidator::validateCategoryExists(
                $newEvent['category'],
                $this->eventModel->getEventCategories()
            );
            $event = new EventEntity(
                $newEvent['id'] ?? '',
                $newEvent['name'],
                $newEvent['category'],
                $newEvent['location'],
                $newEvent['date'],
                $newEvent['startTime'],
                $newEvent['endTime'],
                $newEvent['notes'],
                $newEvent['availableToHP']
            );
            if (!empty($event) && $event instanceof EventEntity) {
                $result = $this->eventModel->addEvent($event);
            }
        } catch (\Exception $exception) {
            $responseData['message'] = $exception->getMessage();
        }

        if (isset($result) && $result) {
            $responseData = [
                'success' => true,
                'message' => 'New Event successfully saved.',
                'data' => []
            ];
            $statusCode = 200;
        }
        return $this->respondWithJson($response, $responseData, $statusCode);
    }
}
