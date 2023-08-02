<template>
    <nav>
        <ul class="flex justify-between px-4">
            <li>
                <img src="../../../public/assets/logo.jpg" alt="refresh-icon" class="h-24">
            </li>
            <li>
                <Link :href="route('logout')" method="post" as="button"
                      class="font-semibold text-gray-500 hover:text-black hover:underline py-6 px-3">
                    <span>Log Out</span>
                </Link>
            </li>
        </ul>
    </nav>
    <section class="mt-4 px-10 md:flex" v-if="loading === false">
        <div class="md:w-4/5">
            <div v-for="quote in quotes" class="grid md:grid-cols-8 mb-6">
                <div class="hidden md:block col-span-1">
                    <img class="h-14 m-auto" src="../../../public/assets/quotation-marks.png" alt="quotation-marks">
                </div>
                <div class="md:col-span-7 mt-2">
                    <p>{{ quote }}</p>
                    <p>- Kanye West</p>
                </div>
            </div>
        </div>
        <div class="md:w-1/5 rounded-lg flex items-center justify-center mb-4">
            <button @click="refresh" class="rounded-lg hover:border-2 hover:border-gray-150 p-1">
                <img src="../../../public/assets/refresh.png" alt="refresh-icon" class="h-24">
                Refresh
            </button>
        </div>
    </section>
    <div v-else class="h-4/5 flex flex-col items-center justify-center">
        <p>Loading...</p>
        <img src="../../../public/assets/kanye.gif" alt="refresh-icon" class="h-48 mt-4 rounded">
    </div>

</template>
<script>
import {Link} from "@inertiajs/vue3";

export default {
    components: {
        Link
    },
    created() {
        this.seen = []
        this.getFiveQuotes();
    },
    data: () => ({
        quotes: [],
        seen: [],
        loading: false
    }),
    methods: {
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
        refresh() {
            this.loading = true
            this.quotes = []
            this.getFiveQuotes()
        }
        // TODO: implement this
        // fixGrammar(quote){
        //     const options = {
        //         method: 'POST',
        //         url: 'https://jspell-checker.p.rapidapi.com/check',
        //         headers: {
        //             'content-type': 'application/json',
        //             'X-RapidAPI-Key': 'SIGN-UP-FOR-KEY',
        //             'X-RapidAPI-Host': 'jspell-checker.p.rapidapi.com'
        //         },
        //         data: {
        //             language: 'enUK',
        //             fieldvalues: quote,
        //             config: {
        //                 forceUpperCase: false,
        //                 ignoreIrregularCaps: false,
        //                 ignoreFirstCaps: true,
        //                 ignoreNumbers: true,
        //                 ignoreUpper: false,
        //                 ignoreDouble: false,
        //                 ignoreWordsWithNumbers: true
        //             }
        //         }
        //     };
        //
        //     try {
        //         const response = await axios.request(options);
        //         console.log(response.data);
        //     } catch (error) {
        //         console.error(error);
        //     }
        // }
    }
}
</script>
