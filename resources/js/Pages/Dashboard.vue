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
    <section class="my-4 md:flex" v-if="loading === false">
        <div class="md:w-4/5 ">
            <div v-for="quote in quotes" class="grid md:grid-cols-8 mb-4 pl-4 pr-4">
                <div class="hidden md:block col-span-1">
                    <img class="h-12 m-auto" src="../../../public/assets/quotation-marks.png" alt="quotation-marks">
                </div>
                <div @click="copy(quote)" class="md:col-span-7 mt-2 cursor-pointer hover:underline hover:underline-offset-2">
                    <div class="text-white m-0 hover:text-gray-600">
                        <span class="text-black">
                            {{ quote }}
                        </span>
                        <ClipboardIcon class="inline mb-1 h-4 w-4 ml-3"/>
                    </div>
                    <p class="text-gray-600 text-sm ml-2 mt-1">- Kanye West</p>
                </div>
            </div>
        </div>
        <div class="md:w-1/5 flex items-center justify-center mb-4 border-l-4 border-gray-100">
            <button @click="refresh" class="rounded-lg hover:border-2 hover:border-gray-150 p-1">
                <img src="../../../public/assets/refresh.png" alt="refresh-icon" class="h-24">
                Refresh
            </button>
        </div>
    </section>
    <div v-else class="flex flex-col items-center justify-center pt-8 space-y-8">
        <p>Loading...</p>
        <img src="../../../public/assets/kanye.gif" alt="refresh-icon" class="h-48 rounded">
    </div>
    <footer class="absolute bottom-0">
        <div class="w-screen text-center text-gray-400 bg-gray-50 p-3">
            <a class="hover:text-black hover:underline hover:underline-offset-2 text-xs"
               href="https://github.com/alley-hen/quote-generator.git" target="_blank">© 2023 Allison Henning</a>
        </div>
    </footer>

</template>
<script>
import {Link} from "@inertiajs/vue3";
import {ClipboardIcon} from '@heroicons/vue/24/outline';
import {router} from "@inertiajs/vue3";

export default {

    components: {
        Link,
        ClipboardIcon
    },

    props: {
        quotes: {
            type: Array,
        }
    },


    data: () => ({
        loading: false
    }),

    methods: {
        copy(quote){
            const copied = `${quote} - Kanye West`
            navigator.clipboard.writeText(copied)
        },
        getQuote() {
            return fetch('https://api.kanye.rest')
                .then(response => response.json())
                .then(data => data.quote)
                .catch((e) => {
                    console.log(e)
                })
        },
        async getFiveQuotes() {
            this.loading = true
            for (let i = 0; i < 5; i++) {
                const quote = await this.getQuote()
                if (this.quotes.indexOf(quote) === -1) {
                    this.quotes.push(quote)
                    this.seen.push(quote)
                } else {
                    i--
                }
            }
            this.loading = false
        },
        async refresh() {
            this.loading = true
            await router.get('/dashboard').then((data) =>{
                this.quotes = data
                this.loading = false
            }).catch((e) => {
                console.log(e)
                this.loading = false
            })
        }
    }
}
</script>
