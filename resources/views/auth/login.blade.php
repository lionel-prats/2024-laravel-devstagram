@extends("layouts.app")

@section("titulo", "Inicia Sesión en Devstagram")

@section('contenido')
    <div class="md:flex justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12 p-5">
            <img src="{{ asset("img/login.jpg") }}" alt="Imagen login de usuarios">
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="POST" action="{{ route("login") }}" id="user-login-form" novalidate>
                @csrf

                @if (session("mensaje"))
                    <p 
                        class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                    >{{ session("mensaje") }}</p>
                @endif

                <div class="mb-5">
                    <label 
                        class="mb-2 block uppercase text-gray-500 font-bold"
                        for="email"
                    >Email</label>
                    <input 
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}"
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Tu Email de Registro"
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
                        for="password"
                    >Pasword</label>
                    <input 
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Password de Registro"
                    >
                    @error("password")
                        <p 
                            class="bg-red-500 text-white my-2 rounded-lg text-sm p-2 text-center"
                        >{{ $message }}</p>
                    @enderror
                </div>
                <input 
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg"
                    type="submit" value="Iniciar Sesión"
                >
            </form>
        </div>
    </div>
    <script src="./js/formValidator.js"></script>

    <script>
        function removeCointainerErrors(nameInput){
            const elementContainerError = document.getElementById(`${nameInput}-errors`);
            if (elementContainerError) {
                elementContainerError.remove();
            }
        }

        const rules = {
            email: ['required', 'validEmail'],
            password: ['required'],
        };

        const validator = new FormValidator('user-login-form', rules);

        document.getElementById('user-login-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const result = validator.validate();
            if (result.valid) {
                Object.keys(rules).forEach((nameInput) => {
                    document.getElementById(nameInput).classList.remove("border-2", "border-rose-600");
                    removeCointainerErrors(nameInput)
                });
                this.submit();
            } else {
                // itero un array con los nombres de los inputs del form
                Object.keys(rules).forEach((nameInput) => {  
                    // actuo sobre cada input que haya tenido errores en el submit 
                    if (Object.keys(result.errors).includes(nameInput)) { 
                        // elimino los errores que puedan haber impresos de un submit anterior
                        removeCointainerErrors(nameInput)
                        // agrego borde azul 
                        document.getElementById(nameInput).classList.add("border-2", "border-blue-500");
                        // armo el div con errores a imprimir debajo de cada input
                        const divContainerError = document.createElement('div');
                        divContainerError.id = `${nameInput}-errors`; // Asignar un nuevo ID al elemento
                        divContainerError.classList.add("mb-5");
                        // genero un solo <small> de error por unput para imprimier en pantalla
                        for (const errorInInput of result.errors[nameInput]) {
                            const errorMessage = document.createElement('p');
                            errorMessage.classList.add("bg-blue-500", "text-white", "my-2", "rounded-lg", "text-sm", "p-2", "text-center");
                            errorMessage.textContent = errorInInput;
                            divContainerError.appendChild(errorMessage);
                            break; // Sale del bucle después de la primera iteración
                        }
                        document.getElementById(nameInput).insertAdjacentElement('afterend', divContainerError);
                    } else {
                        // para input que haya pasado la validacion mientras otros no, remuevo los pisibles estilos y mensajes de error de submit anteriores
                        document.getElementById(nameInput).classList.remove("border-2", "border-rose-600");
                        removeCointainerErrors(nameInput)
                    }
                });
            }
        });
    </script>
@endsection