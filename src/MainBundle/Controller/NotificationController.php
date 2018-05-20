<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    public function getAction()
    {
        // Find the current user
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        // Get the entity manager
        $em = $this->getDoctrine()->getManager();
        // Find the user notifications
        $notifications = $em->getRepository('MainBundle:Notification')->getUnseenNotifications($user);
        // Check the notifications availability
        $response = "";
        if($notifications == null)
            $response = "<p style=\"padding: 4%\" align=\"center\"><strong>Pas de nouveaux notifications</strong></p>";
        else
        {
            // Loop through all the notifications
            foreach ($notifications as $notification) {
                // Mark it as seen
                $notification->setSeen(1);
                // Save the notification
                $em->persist($notification);
                // Construct a notification
                $response = $response . "<li style=\"background-color: white; border-bottom: solid 1px rgb(229, 229, 229); padding: 2%; \">

                            <h6 class=\"popover-title\" style=\"color: black; background-color: white; border-bottom: 0px\"><strong>" .
                    $notification->getContent() .
                    "</strong></h6>
                            <i class=\"" . $notification->getIcon() . "\" style=\"font-size: 10px; color: #" . $notification->getIconColor() . "; padding-left: 12px\"></i>
                            <i align=\"right\" style=\"font-size: 11px\"><strong>5 mins ago</strong></i>

                        </li>";
            }
            // Save the database updates
            $em->flush();
        }
        // Return success
        return new Response($response);
    }
    public function showAction()
    {
        return $this->render("MainBundleBundle:Notification:show.html.twig");
    }

}
