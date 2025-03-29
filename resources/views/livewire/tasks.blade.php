<div class="max-w-lg mx-auto p-6 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg">
    <h2 class="text-xl font-bold text-center mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">Lista de Tareas</h2>

    <form wire:submit.prevent="createTask" class="mb-6 space-y-3">
        <div class="flex justify-between mb-2">
            <h3 class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">
                {{ $isEditing ? 'Editar Tarea' : 'Nueva Tarea' }}
            </h3>
            @if($isEditing)
                <button 
                    type="button"
                    wire:click="cancelEdit"
                    class="text-sm text-[#706f6c] hover:text-[#1b1b18] dark:text-[#A1A09A] dark:hover:text-[#EDEDEC]"
                >Cancelar</button>
            @endif
        </div>

        <div>
            <input 
                type="text" 
                wire:model="title" 
                placeholder="Título" 
                class="w-full p-2 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm dark:bg-[#161615] dark:text-[#EDEDEC]"
            >
            @error('title')
                <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <div>
            <textarea 
                wire:model="description" 
                placeholder="Descripción" 
                class="w-full p-2 border border-[#19140035] dark:border-[#3E3E3A] rounded-sm dark:bg-[#161615] dark:text-[#EDEDEC]"
            ></textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>
        
        <button 
            type="submit" 
            class="w-full py-1.5 rounded-sm font-medium text-sm leading-normal {{ $isEditing ? 'bg-[#1b1b18] hover:bg-black border border-black text-white dark:bg-[#EDEDEC] dark:border-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white' : 'bg-[#1b1b18] hover:bg-black border border-black text-white dark:bg-[#EDEDEC] dark:border-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white' }}"
        >{{ $isEditing ? 'Actualizar' : 'Agregar' }}</button>
    </form>

    <h3 class="font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-3">Mis Tareas ({{ count($tasks) }})</h3>

    @if(count($tasks) > 0)
        <div class="max-h-96 overflow-y-auto pr-2">
            <ul class="space-y-3">
                @foreach($tasks as $task)
                    <li class="p-3 {{ $task->status ? 'bg-[#f5f5f5] dark:bg-[#1a1a1a]' : 'bg-white dark:bg-[#161615]' }} shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-sm flex justify-between items-start">
                        <div class="flex items-start space-x-3 flex-1">
                            <div class="mt-1">
                                <button wire:click="toggleStatus('{{ $task->id }}')" class="flex-shrink-0">
                                    <div class="w-5 h-5 border rounded-full flex items-center justify-center {{ $task->status ? 'bg-[#1b1b18] border-[#1b1b18] dark:bg-[#EDEDEC] dark:border-[#EDEDEC]' : 'border-[#19140035] dark:border-[#3E3E3A]' }}">
                                        @if($task->status)
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-white dark:text-[#1C1C1A]" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        @endif
                                    </div>
                                </button>
                            </div>
                            <div class="flex-1">
                                <div class="flex flex-col">
                                    <strong class="{{ $task->status ? 'line-through text-[#706f6c] dark:text-[#A1A09A]' : 'text-[#1b1b18] dark:text-[#EDEDEC]' }}">
                                        {{ $task->title }}
                                    </strong>
                                    @if($task->description)
                                        <p class="text-sm {{ $task->status ? 'line-through text-[#706f6c] dark:text-[#A1A09A]' : 'text-[#706f6c] dark:text-[#A1A09A]' }}">
                                            {{ $task->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <button 
                                wire:click="editTask('{{ $task->id }}')" 
                                class="px-3 py-1 rounded-sm text-sm leading-normal border border-[#19140035] hover:border-[#1915014a] text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] dark:text-[#EDEDEC]"
                            >Editar</button>
                            <button 
                                wire:click="deleteTask('{{ $task->id }}')" 
                                class="px-3 py-1 rounded-sm text-sm leading-normal bg-[#1b1b18] hover:bg-black border border-black text-white dark:bg-[#EDEDEC] dark:border-[#EDEDEC] dark:text-[#1C1C1A] dark:hover:bg-white dark:hover:border-white"
                            >Eliminar</button>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="text-center py-4 text-[#706f6c] dark:text-[#A1A09A]">
            No hay tareas. ¡Agrega una!
        </div>
    @endif
</div>