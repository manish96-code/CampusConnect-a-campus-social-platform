
<div class="flex justify-center px-4 lg:px-8 py-8 min-h-[80vh] w-full " x-data="{ showCreate: false }">
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        <div class="lg:col-span-11 space-y-8">

            <!-- Page Header -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Campus Groups</h1>
                    <p class="text-slate-500 mt-1">Connect with students who share your interests.</p>
                </div>
                
                <button @click="showCreate = !showCreate" 
                    :class="showCreate ? 'bg-slate-200 text-slate-700' : 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm transition-all transform active:scale-95">
                    
                    <svg x-show="!showCreate" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                    <svg x-show="showCreate" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    
                    <span x-text="showCreate ? 'Cancel' : 'Create Group'"></span>
                </button>
            </div>

            <!-- CREATE GROUP FORM (Collapsible) -->
            <div x-show="showCreate" x-collapse x-cloak>
                <div class="bg-white border border-indigo-100 rounded-3xl p-1 shadow-sm mb-8 relative overflow-hidden">
                    <div class="absolute top-4 right-4 z-10">
                         <button @click="showCreate = false" class="p-2 bg-white/80 hover:bg-slate-100 rounded-full text-slate-400 transition"><i data-feather="x" class="w-4 h-4"></i></button>
                    </div>
                    
                    <livewire:user.group.create-group />
                </div>
            </div>

            <!-- GROUP LIST -->
            <div>
                <livewire:user.group.calling-group />
            </div>


            {{-- <div>
                <livewire:user.group.profile />
            </div> --}}

        </div>

    </div>

    <!-- Icons & Animations -->
    <script>
        document.addEventListener('livewire:initialized', () => feather.replace());
        document.addEventListener('livewire:navigated', () => feather.replace());
    </script>
</div>