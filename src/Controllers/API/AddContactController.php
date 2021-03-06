<?php


namespace Portal\Controllers\API;

use Portal\Abstracts\Controller;
use Portal\Entities\ContactEntity;
use Portal\Models\HiringPartnerModel;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AddContactController extends Controller
{

    private $hiringPartnerModel;

    /**
     * AddContactController constructor.
     * @param $hiringPartnerModel
     */
    public function __construct(HiringPartnerModel $hiringPartnerModel)
    {
        $this->hiringPartnerModel = $hiringPartnerModel;
    }

    public function __invoke(Request $request, Response $response, array $args)
    {
        $newContact = $request->getParsedBody();
        $data = [
            'success' => false,
            'message' => 'Unexpected Error.',
            'data' => $newContact
        ];
        $statusCode = 400;

        try {
            $contact = new ContactEntity(
                $newContact['contactName'],
                $newContact['contactEmail'],
                $newContact['contactJobTitle'],
                $newContact['contactPhone'],
                (int)$newContact['contactCompanyId'],
                (int)$newContact['contactIsPrimary']
            );
            if (!empty($contact) && $contact instanceof ContactEntity) {
                $result = $this->hiringPartnerModel->addNewContact($contact);
            }
        } catch (\Exception $exception) {
            $data['message'] = $exception->getMessage();
        }
        if (isset($result) && $result) {
            $data = [
                'success' => true,
                'message' => 'Contact information saved.',
                'data' => []
            ];
            $statusCode = 200;
        }
        return $this->respondWithJson($response, $data, $statusCode);
    }
}
