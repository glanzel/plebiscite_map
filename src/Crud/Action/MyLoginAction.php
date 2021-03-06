<?php

namespace App\Crud\Action;

use Crud\Action\BaseAction;
use Crud\Event\Subject;
use Crud\Traits\RedirectTrait;

class MyLoginAction extends BaseAction
{

    use RedirectTrait;

    protected $_defaultConfig = [
        'enabled' => true,
        'messages' => [
            'success' => [
                'text' => 'Du bist eingeloggt!'
            ],
            'error' => [
                'text' => 'Email oder Passwort falsch. Bitte versuche es noch einmal'
            ],

            //kann man die "inactive"-Anzeige customizen? "error" ist in rot, gleich zu sehen. "Inactive"-Text leicht zu übersehen.
            'inactive' => [
                'text' => 'Dein Account wurde noch nicht aktiviert. Bitte kontaktiere eine*n Admin.'
            ],

        ],
    ];

    /**
     * HTTP GET handler
     *
     * @return void
     */
    protected function _get()
    {
        $subject = $this->_subject([
            'success' => true,
        ]);

        $this->_trigger('beforeRender', $subject);
    }

    /**
     * HTTP POST handler
     *
     * @return \Cake\Network\Response
     */
    protected function _post()
    {
        $subject = $this->_subject();

        $this->_trigger('beforeLogin', $subject);

        if ($user = $this->_controller()->Auth->identify()) {
            if($user['active']) return $this->_success($subject, $user);
            else{ 
				$this->_error($subject, 'inactive');
			}

        }
		else $this->_error($subject);
    }

    /**
     * Post success callback
     *
     * @param \Crud\Event\Subject $subject Event subject.
     * @param array $user Authenticated user record data.
     * @return \Cake\Network\Response
     */
    protected function _success(Subject $subject, array $user){
        $subject->set(['success' => true, 'user' => $user]);
        $this->_trigger('afterLogin', $subject);
        $this->_controller()->Auth->setUser($subject->user);
        $this->setFlash('success', $subject);

        return $this->_redirect(
            $subject,
            $this->_controller()->Auth->redirectUrl()
        );
        
    }

    /**
     * Post error callback
     *
     * @param \Crud\Event\Subject $subject Event subject
     * @return void
     */
    protected function _error(Subject $subject, $message = 'error')
    {
        $subject->set(['success' => false]);

        $this->_trigger('afterLogin', $subject);
        $this->setFlash($message, $subject);
        $this->_trigger('beforeRender', $subject);
    }
}
