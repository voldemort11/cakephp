<?php
namespace App\Controller;
use App\Controller\AppController;
class UsersController extends AppController
{

 
    public function index()
    {
        $users = $this->paginate($this->Users);
        $this->set(compact('users'));
    }
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        $this->set('user', $user);
    }
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function login()    
	{          
	if ($this->request->is('post')) {
		$user = $this->Auth->identify(); 
		if ($user) {
			$this->Auth->setUser($user);  
			$this->Flash->success('Login success.');
			return $this->redirect(['Controller'=>'Users','action'=>'index']);
			}       
			$this->Flash->error('Your username or password is incorrect.');   
			}  
  }
  
   public function initialize()  
   {        parent::initialize(); 
   $this->Auth->allow(['logout']); 
   }
   
    public function logout()  
	{        $this->Flash->success('You are now logged out.');  
	return $this->redirect($this->Auth->logout());   
	} 
}