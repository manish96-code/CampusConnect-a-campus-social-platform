<div class="pt-6 px-4 lg:px-8">
  <div class="max-w-7xl mx-auto"> 
    <!-- Use flex so the feed + right sidebar are treated as a single centered unit -->
    <div class="flex flex-col lg:flex-row items-start justify-center gap-8">
      
      <!-- MAIN FEED: full width on mobile, constrained width on desktop -->
      <main class="w-full lg:w-[720px] xl:w-[820px] space-y-6">
        <!-- Stories -->
        <div><livewire:user.story /></div>

        <!-- Create Post -->
        <div><livewire:user.post.create-post /></div>

        <!-- News Feed -->
        <div class="pb-20"><livewire:user.post.calling-post /></div>
      </main>

      <!-- RIGHT SIDEBAR: hidden on md/lg, shown on xl -->
      <aside class="hidden xl:block w-80 flex-shrink-0">
        <div class="sticky top-24 space-y-6">
          <livewire:user.online-friends />

          <div class="mt-6 flex flex-wrap gap-x-4 gap-y-1 text-[11px] text-slate-400 px-2">
            <a href="#" class="hover:underline">Privacy</a>
            <a href="#" class="hover:underline">Terms</a>
            <a href="#" class="hover:underline">Advertising</a>
            <span>© {{ date('Y') }} Campus Connect</span>
          </div>
        </div>
      </aside>

    </div>
  </div>
</div>
