<?php declare(strict_types=1);

// src/Controller/RestController.php
namespace App\Controller;

use App\Bundle\{Config, Message, Response};
use App\Entity\Site;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\{JsonResponse, Request};
use Symfony\Component\Routing\Annotation\Route;

class RestController extends Controller
{
    /**
     * @Route("/rest/add-site")
     */
    public function addSiteAction(Request $request): object
    {
        $config = new Config();
        $message = new Message();
        $em = $this->getDoctrine()->getManager();

        $user = $request->headers->get('php-auth-user') ?? '';
        $password = $request->headers->get('php-auth-pw') ?? '';

        $data = json_decode($request->getContent());

        $restUserPassword = $em->getRepository('App:User')
            ->getRestUserPassword($user);
        $passwordVerify = password_verify(
            $password,
            ($restUserPassword) ? $restUserPassword->getPassword() : ''
        );
        if ($passwordVerify) {
            if (strlen($data->name) < 1) {
                $message->addMessage('Nazwa strony www musi zostać podana.');
            } elseif (strlen($data->name) > 100) {
                $message->addMessage(
                    'Nazwa strony www może zawierać maksymalnie 100 znaków.'
                );
            }
            $http = substr($data->url, 0, 7) != 'http://';
            $https = substr($data->url, 0, 8) != 'https://';
            if ($http && $https) {
                $message->addMessage(
                    'Url musi rozpoczynać się od znaków: http://'
                );
            }
            if (strlen($data->url) > 100) {
                $message->addMessage(
                    'Url może zawierać maksymalnie 100 znaków.'
                );
            }
            if (!$message->isMessage()) {
                $site = new Site();
                $site->setUser($restUserPassword);
                $site->setActive(false);
                $site->setVisible(true);
                $site->setName($data->name);
                $site->setUrl($data->url);
                $site->setIpAdded($config->getRemoteAddress());
                $site->setDateAdded($config->getDateTimeNow());
                $site->setIpUpdated('');
                $site->setDateUpdated(new \DateTime('1970-01-01 00:00:00'));
                $em->persist($site);
                try {
                    $em->flush();
                    $message->addMessage(
                        'Strona www została dodana i oczekuje na akceptację.'
                    );
                    $message->setOk(true);
                } catch (\Exception $e) {
                    $message->addMessage(
                        'Dodanie strony www nie powiodło się.'
                    );
                }
            }
        } else {
            $message->addMessage('Błędna autoryzacja przesyłanych danych.');
        }

        $response = new Response();
        $response->message = $message->getStrMessage();
        $response->success = $message->getOk();

        return new JsonResponse($response);
    }

    /**
     * @Route("/rest/update-site")
     */
    public function updateSiteAction(Request $request): object
    {
        $config = new Config();
        $message = new Message();
        $em = $this->getDoctrine()->getManager();

        $user = $request->headers->get('php-auth-user') ?? '';
        $password = $request->headers->get('php-auth-pw') ?? '';

        $data = json_decode($request->getContent());

        $restUserPassword = $em->getRepository('App:User')
            ->getRestUserPassword($user);
        $passwordVerify = password_verify(
            $password,
            ($restUserPassword) ? $restUserPassword->getPassword() : ''
        );
        if ($passwordVerify) {
            $restUserSite = $em->getRepository('App:Site')
                ->isRestUserSite($restUserPassword->getId(), $data->id);
            if (!$restUserSite) {
                $message->addMessage(
                    'Baza nie zawiera podanej strony dla autoryzacji.'
                );
            }
            if (strlen($data->name) < 1) {
                $message->addMessage('Nazwa strony www musi zostać podana.');
            } elseif (strlen($data->name) > 100) {
                $message->addMessage(
                    'Nazwa strony www może zawierać maksymalnie 100 znaków.'
                );
            }
            if (!$message->isMessage()) {
                $siteData = $em->getRepository('App:Site')->setSiteData(
                    $data->id,
                    $data->visible,
                    $data->name,
                    $config->getRemoteAddress(),
                    $config->getDateTimeNow()
                );
                if ($siteData) {
                    $message->addMessage('Dane strony www zostały zapisane.');
                    $message->setOk(true);
                } else {
                    $message->addMessage(
                        'Zapisanie danych strony www nie powiodło się.'
                    );
                }
            }
        } else {
            $message->addMessage('Błędna autoryzacja przesyłanych danych.');
        }

        $response = new Response();
        $response->message = $message->getStrMessage();
        $response->success = $message->getOk();

        return new JsonResponse($response);
    }

    /**
     * @Route("/rest/delete-site")
     */
    public function deleteSiteAction(Request $request): object
    {
        $message = new Message();
        $em = $this->getDoctrine()->getManager();

        $user = $request->headers->get('php-auth-user') ?? '';
        $password = $request->headers->get('php-auth-pw') ?? '';

        $data = json_decode($request->getContent());

        $restUserPassword = $em->getRepository('App:User')
            ->getRestUserPassword($user);
        $passwordVerify = password_verify(
            $password,
            ($restUserPassword) ? $restUserPassword->getPassword() : ''
        );
        if ($passwordVerify) {
            $restUserSite = $em->getRepository('App:Site')
                ->isRestUserSite($restUserPassword->getId(), $data->id);
            if (!$restUserSite) {
                $message->addMessage(
                    'Baza nie zawiera podanej strony dla autoryzacji.'
                );
            }
            if (!$message->isMessage()) {
                $siteData = $em->getRepository('App:Site')
                    ->deleteSiteData($data->id);
                if ($siteData) {
                    $message->addMessage('Dane strony www zostały usunięte.');
                    $message->setOk(true);
                } else {
                    $message->addMessage(
                        'Usunięcie danych strony www nie powiodło się.'
                    );
                }
            }
        } else {
            $message->addMessage('Błędna autoryzacja przesyłanych danych.');
        }

        $response = new Response();
        $response->message = $message->getStrMessage();
        $response->success = $message->getOk();

        return new JsonResponse($response);
    }
}
