@extends('layouts.app')
<div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <!-- Register Card -->
          <div class="card px-sm-6 px-0">
            <div class="card-body">
              <!-- Logo -->
              <div class="app-brand justify-content-center mb-6">
                <a href="index.html" class="app-brand-link gap-2">
                    <span class="app-brand-logo demo">
                        <img src="https://arinadigital.com/wp-content/uploads/2023/12/logo.svg" alt="Arina Digital">
                    </span>
                </a>
              </div>
              <form method="POST" action="{{ route('register') }}">
                @csrf
              <input
                type="text"
                    class="form-control"
                    id="first_name"
                    name="first_name"
                    placeholder="Can"
                    hidden/>
                <div class="mb-6">
                <label for="name" class="form-label">Adınız</label>
                <input
                    type="text"
                    class="form-control"
                    id="name"
                    name="name"
                    placeholder="Can"
                    autofocus />
                </div>    
                <div class="mb-6">
                  <label for="last_name" class="form-label">Soyadınız</label>
                  <input
                    type="text"
                    class="form-control"
                    id="last_name"
                    name="last_name"
                    placeholder="Cetin"
                    autofocus />
                </div>
                <div class="mb-6">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="can.cetin@arinadigital.com" />
                </div>
                <div class="mb-6">
                  <label for="phone" class="form-label">Telefon Numaranız</label>
                  <input
                    type="text"
                    class="form-control"
                    id="phone"
                    name="phone"
                    placeholder="+90 (555) XXX XXXX"
                    autofocus />
                </div>
                <div class="mb-6">
                  <label for="title" class="form-label">Unvan</label>
                  <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    placeholder="Web Developer"
                    autofocus />
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
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password_confirmation">Tekrar Şifre</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password_confirmation"
                      class="form-control"
                      name="password_confirmation"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password_confirmation" />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100">Kayıt Ol</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('name');
    const firstNameInput = document.getElementById('first_name');

    nameInput.addEventListener('input', function() {
        firstNameInput.value = nameInput.value;
    });
});
</script>
