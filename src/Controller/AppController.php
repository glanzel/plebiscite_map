<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use CrudView\Menu\MenuItem;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class AppController extends Controller{
    
    public function beforeFilter(Event $event){
        $menu = $this->getMenu($this->Auth->user());
        $this->set('utilityNavigation', $menu);
        //$this->Crud->action()->config('scaffold.utility_navigation', $menu);
    }
    
    public function getMenu($user){
        $menu = [
            new MenuItem(
                'Ort+',
                ['controller' => 'Orte', 'action' => 'add']
                ),
            new MenuItem(
                'Sammelorte-Karte',
                ['controller' => 'Pages', 'action' => 'karte']
                )
        ];
        $outMenu = [
            new MenuItem(
                'Log In',
                ['controller' => 'Users', 'action' => 'login']
                ),
            new MenuItem(
                'Register',
                ['controller' => 'Users', 'action' => 'register']
                )];
        $inMenu = [
            new MenuItem(
                'Orte',
                ['controller' => 'Orte', 'action' => 'index']
                ),
            new MenuItem(
                'Benutzer',
                ['controller' => 'Users', 'action' => 'index']
                ),
            new MenuItem(
                'Termin+',
                ['controller' => 'Termine', 'action' => 'add']
                ),
            new MenuItem(
                'Termine',
                ['controller' => 'Termine', 'action' => 'index']
                ),
            new MenuItem(
                'Log Out',
                ['controller' => 'Users', 'action' => 'logout']
                ),
            ];
        $menu = $user ? array_merge($menu, $inMenu) : array_merge($menu, $outMenu);
        return $menu;
        
    }
    

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email', 'password' => 'password']
                ]
            ]
        ]);
        $this->viewBuilder()->setLayout('admin');
        $this->set('siteTitle', 'dwe Sammelseite');
        $this->set('disableSidebar', true);
        
        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }
        
}
