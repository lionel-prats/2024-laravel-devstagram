@extends("layouts.app")

@section("titulo", "Editar Perfil: " . auth()->user()->username)
@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form method="POST" action="{{route("perfil.store")}}" class="mt-10 md:mt-0" enctype="multipart/form-data" novalidate>
                @csrf
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="email"
                    >Email</label>
                    <input 
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{auth()->user()->email}}"
                    >
                    @error("email")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="username"
                    >Username</label>
                    <input 
                        type="text"
                        id="username"
                        name="username"
                        placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{auth()->user()->username}}"
                    >
                    @error("username")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="imagen"
                    >Imagen Perfil</label>
                    <input 
                        type="file"
                        accept=".jpg, .jpeg, .png"
                        id="imagen"
                        name="imagen"
                        class="border p-3 w-full rounded-lg"
                        value=""
                    >
                </div>

                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-blue-800 font-bold"
                        for="password"
                    >Cambiar Pasword (OPCIONAL)</label>
                    <input 
                        class="border border-blue-800 p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingrese su nuevo password"
                    >
                    @error("password")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-blue-800 font-bold"
                        for="password_confirmation"
                    >Confirmar Nuevo Pasword</label>
                    <input 
                        class="border border-blue-800 p-3 w-full rounded-lg"
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Repite tu password"
                    >
                </div> 


                {{-- password actual para confirmar cambios --}}
                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-green-800 font-bold"
                        for="verified_password"
                    >Verificación Pasword Actual</label>
                    <input 
                        class="border border-green-800 p-3 w-full rounded-lg @error('verified_password') border-red-500 @enderror"
                        type="password"
                        id="verified_password"
                        name="verified_password"
                        placeholder="Ingresa tu password actual para confirmar los cambios"
                    >
                    @error("verified_password")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>

                <input 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg mb-5"
                    type="submit" value="Confirmar Cambios"
                >
                <a
                    class="bg-green-600 hover:bg-green-700 transition-colors cursor-pointer uppercase font-bold p-3 text-white rounded-lg block text-center" 
                    href="{{route("posts.index", auth()->user())}}"
                >Cancelar</a>
            </form>
        </div>
    </div>
@endsection