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
use \Crud\Controller\ControllerTrait;
use CrudView\Menu\MenuDivider;
use CrudView\Menu\MenuDropdown;
use CrudView\Menu\MenuItem;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3/en/controllers.html#the-app-controller
 */
class CrudAppController extends AppController
{
    
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
            
            $this->loadComponent('RequestHandler');
            $this->loadComponent('Flash');
            
            $this->loadComponent('Crud.Crud', [
                'actions' => [
                    'Crud.Index',
                    'Crud.View',
                    'Crud.Add',
                    'Crud.Edit',
                    'Crud.Delete'
                ],
                'listeners' => [
                    // New listeners that need to be added:
                    'CrudView.View',
                    'Crud.Redirect',
                    'Crud.RelatedModels',
                    'CrudJsonApi.JsonApi',
                    // If you need searching. Generally it's better to load these
                    // only in the controller for which you need searching.
                    //'Crud.Search',
                    //'CrudView.ViewSearch',
                ]
            ]);
            
            $this->loadComponent('Auth', [
			'authenticate' => [
				'Form' => [
					'fields' => ['username' => 'email', 'password' => 'password']
				]
			]
		]);

            
            /*
             * Enable the following component for recommended CakePHP security settings.
             * see https://book.cakephp.org/3/en/controllers/components/security.html
             */
            //$this->loadComponent('Security');
        }

        function beforeFilter(\Cake\Event\Event $event){
            //debug($this->Crud);

            if(isset($this->Crud) && $this->Crud->action()->enabled()){

				$this->Crud->action()->config('scaffold.sidebar_navigation', false);
				$menu = [
					new MenuItem(
						'Ort+',
						['controller' => 'Orte', 'action' => 'add']
					)];
				$outMenu = [	
					new MenuItem(
						'Log In',
						['controller' => 'Users', 'action' => 'login']
					),
					new MenuItem(
						'Register',
						['controller' => 'Users', 'action' => 'login']
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
						'Log Out',
						['controller' => 'Users', 'action' => 'logout']
					)
				];
				$menu = $this->Auth->user() ? array_merge($menu, $inMenu) : array_merge($menu, $outMenu);
				
				$this->Crud->action()->config('scaffold.utility_navigation', $menu);
			}
		}
        
        /**
         * Before render callback.
         *
         * @param \Cake\Event\Event $event The beforeRender event.
         * @return void
         */
        public function beforeRender(\Cake\Event\Event $event)
        {
            // For CakePHP 3.4+

            if ($this->viewBuilder()->getClassName() === null) {
                $this->viewBuilder()->setClassName('CrudView\View\CrudView');
            }
            
        }
    
}
