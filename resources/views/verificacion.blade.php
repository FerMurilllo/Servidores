<x-guest-layout>
    <!-- Session Status -->

    <form method="POST" action="{{ route('validar_login') }}">
        @csrf
        <h3 class="mt-12 text-xl font-semibold text-gray-900 dark:text-white " style="margin:20px; text-align:center;">INGRESA EL CODIGO</h3>
        <!-- Email Address -->
        <div>
            <x-input-label/>
            <x-text-input id="codigo" class="block mt-5 w-full" type="codigo" name="codigo"  required autofocus />
            
        </div>
       
            <x-primary-button class="ml-3 " style="margin-left: 35%; margin-top: 5%;">
               {{'VERIFICAR'}}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
