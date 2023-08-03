<template>
    <article class="h-screen w-100 text-center flex flex-col items-center justify-center">
        <img src="../../../public/assets/logo.jpg" alt="refresh-icon" class="h-24">
        <div class="mt-8">
            <Link :href="route('login')"
                  class="font-semibold text-gray-500 hover:text-black hover:underline p-1" >
                Log in
            </Link>
            <Link :href="route('register')"
                  class="ml-4 font-semibold text-gray-500 hover:text-black hover:underline p-1">
                Register
            </Link>
        </div>
    </article>
</template>

<script>
import {Link} from '@inertiajs/vue3';

export default {
    components: {
        Link,
    },
}
</script>

