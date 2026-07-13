<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Newsletter extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $error['danger'] = 41;
        if($this->validator->is()){
            $post = $this->validator->get();
            extract($post);

            # Email au client
            $name = bin2hex(openssl_random_pseudo_bytes(5));
            $this->mail->selfMail();
            $this->mail->addReplyTo( $email, 'Newsletter N° ' . $name );
            $this->mail->Subject = "[" . strtoupper(SITE_NAME) . "] - " . translate(77);
            $this->mail->setBody('newsletter', $post );

            if ( $this->mail->send() ) {
                $error['success'] = 78;
            }

            $this->session->set(compact('error'));
        }

        if ( !isset($target) ) {
            $target = 'index';
        }

        redirectTo($target);
        $this->setException();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
