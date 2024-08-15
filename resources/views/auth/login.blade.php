@extends('layouts.app')
<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <div class="app-brand justify-content-center">
                <a href="index.html" class="app-brand-link gap-2">
                  <span class="app-brand-logo demo">
                    <img src="https://arinadigital.com/wp-content/uploads/2023/12/logo.svg" alt="Arina Digital">
                  </span>
                </a>
              </div>
              <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-6">
                  <label for="email" class="form-label">Email Adresiniz</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="can.cetin@arinadigital.com"
                    autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Şifre</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                  <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mb-8">
                  <div class="d-flex justify-content-between mt-8">
                    <div class="form-check mb-0 ms-2">
                      <input name="remember_me" class="form-check-input" type="checkbox" id="remember_me" />
                      <label class="form-check-label" for="remember_me"> Beni Hatırla </label>
                    </div>
                  </div>
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Giriş Yap</button>
                </div>
              </form>

              <!-- <p class="text-center">
                <span>Arina Digital'de yeni misin?</span>
                <a href="auth-register-basic.html">
                  <span>Kayıt Ol!</span>
                </a>
              </p> -->
            </div>
          </div>
        </div>
      </div>
    </div>
