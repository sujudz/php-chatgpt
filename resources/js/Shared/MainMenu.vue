<template>
  <div>
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div>
      <Link class="group flex items-center py-3" href="#">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('setting') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('setting') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">AI Tools</div>

        <icon name="arrow" class="mr-2 w-6 h-6" :class="isUrl('setting') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      </Link>

      <div>
        <div class="mb-4 ml-8">
          <Link class="group flex items-center py-3" href="/chat">
            
            <div :class="isUrl('chat') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">AI Chat</div>
          </Link>
        </div>
      </div>

      <div>
        <div class="mb-4 ml-8">
          <Link class="group flex items-center py-3" href="/write">
            
            <div :class="isUrl('write') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">AI Write</div>
          </Link>
        </div>
      </div>

    </div>
    

    <div>
      <Link class="group flex items-center py-3" href="#">
        <icon name="office" class="mr-2 w-4 h-4" :class="isUrl('setting') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('setting') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">System</div>

        <icon name="arrow" class="mr-2 w-6 h-6" :class="isUrl('setting') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
      </Link>

      <div>
        <div class="mb-4 ml-8">
          <Link class="group flex items-center py-3" href="/setting">
            
            <div :class="isUrl('setting') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Base Setting</div>
          </Link>
        </div>
      </div>

      <div>
        <div class="mb-4 ml-8">
          <Link class="group flex items-center py-3" href="/prompt">
            
            <div :class="isUrl('prompt') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Prompt Template</div>
          </Link>
        </div>
      </div>

      <div>
        <div class="mb-4 ml-8">
          <Link class="group flex items-center py-3" href="/keyword_filter">
            
            <div :class="isUrl('keyword_filter') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Sensitive Words</div>
          </Link>
        </div>
      </div>
    </div>


  </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
