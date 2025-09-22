<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function () {
   /** @TODO Login route - base on OTP */
   /** @TODO Signup route - base on OTP */
});
Route::middleware(['auth:sanctum'])->prefix('panel')->group(function () {
   /** @TODO Logout route */
});
