<?php

function generateToken()
{
	$generated_token = base64_encode(sha1(rand(1, 10000) . uniqid() . time()));
	//manage token ini akan expired dalam jangka waktu berapa lama
	$expired = date('Y-m-d H:i:s', strtotime('+1 day'));

    $user = Auth::user();
	//proses simpan token ke database
	$tokenInstance = new \App\tokenManagement;
	$tokenInstance->user_id = $user->id;
	$tokenInstance->access_token = $generated_token;
	$tokenInstance->expired_at = $expired;
	$tokenInstance->is_active = 1;
	$tokenInstance->save();

	//setelah token direcord ke database, kembalikan nilai token ke response
	return $tokenInstance;
}