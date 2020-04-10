<?php declare(strict_types=1);

namespace App\Controller;

use App\Phone\PhoneNumber;
use App\Service\PhoneInfoService;
use InvalidArgumentException;
use Laminas\Hydrator\ClassMethodsHydrator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="main_form", methods={"GET"})
     * @param Request $request
     * @param PhoneInfoService $phoneInfoService
     * @return Response
     */
    public function form(Request $request, PhoneInfoService $phoneInfoService): Response
    {
        $phone = $request->get('phone', '');

        return $this->render(
            'main.html.twig',
            [
                'phone' => $phone
            ]
        );
    }

    /**
     * @Route("/", name="main_handler", methods={"POST"})
     * @param Request $request
     * @param PhoneInfoService $phoneInfoService
     * @return Response
     */
    public function handler(Request $request, PhoneInfoService $phoneInfoService): Response
    {
        $phone = $request->get('phone', '');

        $messages = [];

        if (!$this->phoneIsValid($phone)) {
            $messages[] = 'Номер телефона указан неверно либо он не валиден';
        }

        $phoneInfo = null;
        if (count($messages) === 0) {
            try {
                $hydrator = new ClassMethodsHydrator();
                $phoneInfoObject = $phoneInfoService->get(new PhoneNumber($phone));
                $phoneInfo = $hydrator->extract($phoneInfoObject);
            } catch (Throwable $e) {
                $message = sprintf('Возникла ошибка, попробуйте повторить попытку, код: %s', $e->getCode());
                $messages[] = $message;
            }
        }

        return $this->json([
            'phone' => $phone,
            'messages' => $messages,
            'info' => $phoneInfo
        ]);
    }

    private function phoneIsValid(string $phone): bool
    {
        try {
            new PhoneNumber($phone);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return true;
    }
}
