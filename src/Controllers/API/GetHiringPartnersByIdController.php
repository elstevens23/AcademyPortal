<?php

namespace Portal\Controllers\API;

use Portal\Abstracts\Controller;
use Portal\Models\EventModel;
use Portal\Models\HiringPartnerModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetHiringPartnersByIdController extends Controller
{
    /**
     * @var HiringPartnerModel created by constructor
     */
    private $model;

    /**
     * @var EventModel created by constructor
     */
    private $event;

    private $hpIdsData;

    private $hpEntities = [];

    /**
     * GetHiringPartnersByIdController constructor to populate the model and event properties in this class.
     *
     * @param HiringPartnerModel $model
     *
     * @param EventModel $event
     */
    public function __construct(HiringPartnerModel $model, EventModel $event)
    {
        $this->model = $model;
        $this->event = $event;
    }

    /**
     * Invoke function to get all hiring partners associated with an event and returns JSON
     *
     * @param Request $request
     *
     * @param Response $response
     *
     * @param $args an array of arguments
     *
     * @return JSON response containing hpEntities
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $id = $request->getParsedBody()['event_id'];
        $this->hpIdsData = $this->event->hpIdsByEventId($id);
        foreach ($this->hpIdsData as $hpId) {
            $getHiringPartnerIdData = $this->model->getHiringPartnerById($hpId['hiring_partner_id']);
            if ($getHiringPartnerIdData['success']) {
                $hpEntity = $getHiringPartnerIdData['entity'];
                $hpEntity['attendees'] = $hpId['people_attending'];
                array_push($this->hpEntities, $hpEntity);
            } else {
                return $this->respondWithJson($response, ['message' => 'Database error'], 500);
            }
        }
        return $this->respondWithJson($response, $this->hpEntities);
    }
}
