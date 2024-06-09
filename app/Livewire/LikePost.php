<?php

namespace App\Livewire;

use Livewire\Component;

class LikePost extends Component
{
    public $post; // instancia de Post, nos la tienen que enviar cuando se invoca a este componente desde algun blade

    public $isLiked;
    public $likes;

    // este metodo se ejecuta automaticamente cuando es instanciado este componente desde algun blade 
    public function mount($post)
    {
        $this->isLiked = $post->checkLike(auth()->user());
        $this->likes = $post->likes()->count();
    }

    public function like()
    {
        // if($this->post->checkLike(auth()->user())){
        if($this->isLiked){
            $this->post->likes()
                ->where("user_id", auth()->user()->id)
                ->delete();
            $this->isLiked = false;
            $this->likes--;
        } else {
            $this->post->likes()->create([
                "user_id" => auth()->user()->id
            ]);
            $this->isLiked = true;
            $this->likes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
