<div class="flex gap-5 justify-center  py-10">

    <!-- sidebar -->
    <div class="w-2/12">
        <livewire:user.sidebar />
    </div>

    <!-- post  -->
    <div class="w-5/12">

        <div>
            <livewire:user.story>
        </div>

        <div>
            <livewire:user.post.create-post />
            <livewire:user.post.calling-post />
        </div>
    </div>

    <!-- ad -->
    <div class="w-3/12"></div>

    <!-- friends -->
    <div class="w-2/12 bg-white h-screen fixed top-16 right-0 p-5">
        <livewire:user.online-friends>
    </div>
</div>
