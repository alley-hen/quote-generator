<template>
    <nav class="border-b-4 border-gray-100">
        <ul class="flex justify-between items-center px-4 py-1">
            <li>
                <img src="../../../public/assets/logo.jpg" alt="refresh-icon" class="h-24">
            </li>
            <li>
                <Link :href="route('logout')" method="post" as="button"
                      class="font-semibold text-gray-500 hover:text-black hover:underline hover:underline-offset-2 py-6 px-3">
                    <span>Log Out</span>
                </Link>
            </li>
        </ul>
    </nav>
    <section class="my-8 md:flex" v-if="loading === false">
        <div class="md:w-4/5" v-if="quotesHaveLoaded">
            <div v-for="quote in quotes" key="quote.id" class="grid md:grid-cols-8 my-4 pl-4 pr-4">
                <div class="hidden md:block col-span-1">
                    <img class="h-12 m-auto" src="../../../public/assets/quotation-marks.png" alt="quotation-marks">
                </div>
                <div @click="copy(quote)"
                     class="md:col-span-7 mt-2 cursor-pointer md:hover:underline hover:underline-offset-2">
                    <div class="text-white m-0 hover:text-gray-600">
                            <span class="text-black text-xl">
                                {{ quote.quote }}
                            </span>
                        <ClipboardIcon class="inline mb-1 h-4 w-4 ml-3"/>
                    </div>
                    <p class="text-gray-600 text-sm ml-2 mt-1">- Kanye West</p>
                </div>
            </div>
        </div>
        <div class="text-center m-auto" v-else>
            <p>Sorry, we were unable to load any Kanye quotes. Please click on refresh or restart, or try again
                later.</p>
        </div>
        <div class="md:w-1/5 flex md:flex-col items-center justify-around mb-4 border-l-4 border-gray-100">
            <button @click="refresh" class="rounded-lg hover:border-2 hover:border-gray-150 p-3">
                <ArrowPathIcon class="h-18 text-black"/>
                Refresh
            </button>
            <button @click="restart" class="rounded-lg hover:border-2 hover:border-gray-150 p-3">
                <ArrowRightOnRectangleIcon class="h-18 text-black"/>
                Restart
            </button>
        </div>
    </section>
    <div v-else class="flex flex-col items-center justify-center pt-8 space-y-8">
        <p>Loading...</p>
        <img src="../../../public/assets/kanye.gif" alt="refresh-icon" class="h-48 rounded">
    </div>
    <footer class="md:absolute md:bottom-0">
        <div class="w-screen text-center text-gray-400 bg-gray-50 p-3">
            <a class="hover:text-black hover:underline hover:underline-offset-2 text-xs"
               href="https://github.com/alley-hen/quote-generator.git" target="_blank">© 2023 Allison Henning</a>
        </div>
    </footer>

</template>
<script>
import {Link} from "@inertiajs/vue3";
import {ClipboardIcon, ArrowPathIcon, ArrowRightOnRectangleIcon} from '@heroicons/vue/24/outline';
import {router} from "@inertiajs/vue3";

export default {

    components: {
        Link,
        ClipboardIcon,
        ArrowPathIcon,
        ArrowRightOnRectangleIcon,
    },

    props: {
        quotes: {
            type: Array,
        }
    },


    data: () => ({
        loading: false,
    }),

    computed: {
        quotesHaveLoaded() {
            return this.quotes?.length > 0
        }
    },

    methods: {
        copy(quote) {
            const copied = `${quote} - Kanye West`
            navigator.clipboard.writeText(copied)
        },
        async submitRequest(url) {
            this.loading = true
            await router.get(url).then((data) => {
                this.quotes = data
                this.loading = false
                this.search = ''
            }).catch((e) => {
                console.log(e)
                this.loading = false
            })
        },
        refresh() {
            const url = '/dashboard'
            this.submitRequest(url)
        },
        restart() {
            const url = '/dashboard/restart'
            this.submitRequest(url)
        },
    }
}
</script>
