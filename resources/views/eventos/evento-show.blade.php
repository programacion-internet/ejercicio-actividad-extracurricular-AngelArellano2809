<x-layouts.app :title="__('Detalles evento')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">

            <!-- Detalles del evento -->
            <h1 class="text-2xl font-bold">{{ $evento->nombre }}</h1>
            <h2 class="text-lg">{{ $evento->descripcion }}</h2>
            <h3 class="text-gray-600">{{ $evento->fecha->format('d/m/Y') }}</h3>

            <hr class="my-4">

            <!-- Lista de alumnos inscritos -->
            <h2 class="text-xl font-semibold">Alumnos inscritos</h2>
            <ul class="list-disc pl-5">
                @foreach ($evento->users as $user)
                    <li>{{ $user->name }} - {{ $user->id }}</li>
                @endforeach
            </ul>

            <hr class="my-4">

            <!-- Botón de inscripción (solo para alumnos) -->
            @auth
                @if (!auth()->user()->is_admin) <!-- Solo si NO es admin -->
                    <h2 class="text-xl font-semibold">Inscribirse a evento</h2>
                    <form action="{{ route('eventos.inscribir', $evento) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            Inscribirme a este evento
                        </button>
                    </form>
                @endif
            @else
                <p class="text-gray-500">Debes iniciar sesión para inscribirte</p>
            @endauth

        </div>
    </div>
</x-layouts.app>
