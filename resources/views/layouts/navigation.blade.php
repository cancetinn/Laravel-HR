<nav class="md:w-1/3 left-side px-8 py-9 flex-col justify-between hidden md:flex md:py-8 md:px-7 xl:w-2/12 h-full" x-data="{ open: {{ request()->routeIs('leave.requests', 'short_leaves.index') ? 'true' : 'false' }} }">
    <div>
        <div class="flex items-center mb-10">
            <img src="https://arinadigital.com/wp-content/uploads/2023/12/logo.svg" alt="Arina Digital">
        </div>
        <ul>
            <!-- Dashboard -->
            <li class="mb-10">
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('dashboard') ? 'text-black font-bold' : 'text-zinc-500' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.07874 16.1354H14.8937" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.40002 13.713C2.40002 8.082 3.01402 8.475 6.31902 5.41C7.76502 4.246 10.015 2 11.958 2C13.9 2 16.195 4.235 17.654 5.41C20.959 8.475 21.572 8.082 21.572 13.713C21.572 22 19.613 22 11.986 22C4.35903 22 2.40002 22 2.40002 13.713Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-base font-semibold ml-3">Dashboard</span>
                </a>
            </li>

            <!-- İzinler - Dropdown Menü -->
            <li class="mb-10">
                <a href="#" class="flex items-center p-2 rounded-lg hover:bg-gray-100 cursor-pointer {{ request()->routeIs('leave.requests', 'short_leaves.index') ? 'text-black font-bold' : 'text-zinc-500' }}" @click.prevent="open = !open">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.07874 16.1354H14.8937" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.40002 13.713C2.40002 8.082 3.01402 8.475 6.31902 5.41C7.76502 4.246 10.015 2 11.958 2C13.9 2 16.195 4.235 17.654 5.41C20.959 8.475 21.572 8.082 21.572 13.713C21.572 22 19.613 22 11.986 22C4.35903 22 2.40002 22 2.40002 13.713Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-base font-semibold ml-3">İzinler</span>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="ml-auto transform transition-transform duration-200">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                    </svg>
                </a>
                <ul x-show="open" x-collapse class="ml-8 mt-2 space-y-3">
                    <li>
                        <a href="{{ route('short_leaves.index') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('short_leaves.index') ? 'text-black font-bold' : 'text-zinc-500' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.07874 16.1354H14.8937" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.40002 13.713C2.40002 8.082 3.01402 8.475 6.31902 5.41C7.76502 4.246 10.015 2 11.958 2C13.9 2 16.195 4.235 17.654 5.41C20.959 8.475 21.572 8.082 21.572 13.713C21.572 22 19.613 22 11.986 22C4.35903 22 2.40002 22 2.40002 13.713Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="text-base font-semibold ml-3">Kısa İzin</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('leave.requests') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('leave.requests') ? 'text-black font-bold' : 'text-zinc-500' }}">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.07874 16.1354H14.8937" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.40002 13.713C2.40002 8.082 3.01402 8.475 6.31902 5.41C7.76502 4.246 10.015 2 11.958 2C13.9 2 16.195 4.235 17.654 5.41C20.959 8.475 21.572 8.082 21.572 13.713C21.572 22 19.613 22 11.986 22C4.35903 22 2.40002 22 2.40002 13.713Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span class="text-base font-semibold ml-3">Yıllık İzin</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Belgeler -->
            <li class="mb-16">
                <a href="{{ route('documents') }}" class="flex items-center p-2 rounded-lg hover:bg-gray-100 {{ request()->routeIs('documents') ? 'text-black font-bold' : 'text-zinc-500' }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g opacity="0.4">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 9.5C13.3809 9.5 14.5 10.6191 14.5 12C14.5 13.3809 13.3809 14.5 12 14.5C10.6191 14.5 9.5 13.3809 9.5 12C9.5 10.6191 10.6191 9.5 12 9.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.168 7.25025V7.25025C19.4845 6.05799 17.9712 5.65004 16.7885 6.33852C15.7598 6.93613 14.4741 6.18838 14.4741 4.99218C14.4741 3.61619 13.3659 2.5 11.9998 2.5V2.5C10.6337 2.5 9.52546 3.61619 9.52546 4.99218C9.52546 6.18838 8.23977 6.93613 7.21199 6.33852C6.02829 5.65004 4.51507 6.05799 3.83153 7.25025C3.14896 8.4425 3.55399 9.96665 4.73769 10.6541C5.76546 11.2527 5.76546 12.7473 4.73769 13.3459C3.55399 14.0343 3.14896 15.5585 3.83153 16.7498C4.51507 17.942 6.02829 18.35 7.21101 17.6625H7.21199C8.23977 17.0639 9.52546 17.8116 9.52546 19.0078V19.0078C9.52546 20.3838 10.6337 21.5 11.9998 21.5V21.5C13.3659 21.5 14.4741 20.3838 14.4741 19.0078V19.0078C14.4741 17.8116 15.7598 17.0639 16.7885 17.6625C17.9712 18.35 19.4845 17.942 20.168 16.7498C20.8515 15.5585 20.4455 14.0343 19.2628 13.3459H19.2618C18.2341 12.7473 18.2341 11.2527 19.2628 10.6541C20.4455 9.96665 20.8515 8.4425 20.168 7.25025Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </g>
                    </svg>
                    <span class="text-base font-semibold text-zinc-500 ml-3">Belgeler</span>
                </a>
            </li>
        </ul>
    </div>
    
    <!-- Yönetim Paneli ve Yardım Butonu -->
    <div class="mt-auto">
        @if(auth()->user() && auth()->user()->role === 1)
        <a href="{{ route('admin.dashboard') }}" class="flex items-center hover:bg-gray-100 p-2 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
</svg>
            <span class="ml-3 text-base font-semibold">Yönetim Paneli</span>
        </a>
        @endif

        <button id="dataBtn" class="flex items-center hover:bg-gray-100 p-2 rounded-lg mt-4">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z"/>
            </svg>
            <span class="ml-3 text-base font-semibold">Yardım</span>
        </button>
    </div>
</nav>


<div id="dataModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-screen-md w-full">
        <h2 class="text-lg font-semibold mb-4">Oturum Verileri</h2>
        <pre id="sessionData" class="text-sm text-gray-800 bg-gray-100 p-4 rounded overflow-auto max-h-96"></pre>
        <button id="closeModal" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">Kapat</button>
    </div>
</div>


<script>
    const sessionData = {
        Kimlik: "{{ session()->getId() }}",
        KullanıcıNo: "{{ auth()->user()->id }}",
        IPAdress: "{{ request()->ip() }}",
    };

    document.getElementById('dataBtn').addEventListener('click', function() {
        document.getElementById('sessionData').textContent = JSON.stringify(sessionData, null, 2);
        document.getElementById('dataModal').classList.remove('hidden');
    });

    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('dataModal').classList.add('hidden');
    });
</script>
