<?php

namespace Portal\Controllers;

use Portal\Abstracts\Controller;
use Portal\Models\StageModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Portal\Entities\OptionsEntity;

class AddStageOptionController extends Controller
{
    private $stageModel;
    private $options;
    private $stageId;

     /** Constructor assigns StageModel to this object
     *
     * AddStageOptionController constructor.
     * @param StageModel $stageModel
     */
    public function __construct(StageModel $stageModel)
    {
        $this->stageModel = $stageModel;
    }

    /** On invoke, check request input for optionTitle value, then create new OptionsEntity to send to DB via StageModel
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response - with json and status 200/500 for success or failure.
     */
    public function __invoke(Request $request, Response $response, array $args)
    {
        $formOptions = $request->getParsedBody();

        $data = [
            'success' => false,
            'message' => 'Unexpected Error.',
            'data' => []
        ];
        $statusCode = 500;

        if ($_SESSION['loggedIn'] === true) {
            if (!empty($formOptions['optionTitle'])) {
                foreach ($formOptions as $option) {
                    if ($this->stageModel->addOption($option)) {
                        $data = [
                            'success' => true,
                            'message' => 'Option added successfully',
                            'data' => []
                        ];
                        $statusCode = 200;
                    } else {
                        $data['message'] = 'Error adding to database';
                    }
                }
            } else {
                $statusCode = 400;
                $data['message'] = 'You must type an option';
            }
            return $this->respondWithJson($response, $data, $statusCode);
        }
    }
}
