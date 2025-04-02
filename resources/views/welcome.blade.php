<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    </head>
    <body class="antialiased bg-white">
        <livewire:user-navbar />

        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-10 sm:px-6 lg:px-8 pt-32 pb-16 sm:pt-36 sm:pb-20">
                <div class="text-center" data-aos="fade-up">
                    <h1 class="text-4xl sm:text-6xl font-bold text-gray-900 mb-6">
                        Learn Without Limits
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
                        Discover courses that will transform your career. Learn from industry experts and join a community of learners.
                    </p>
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150">
                            Explore Courses
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                            Get Started
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute inset-0 -z-10 h-full w-full bg-white bg-[linear-gradient(to_right,#f0f0f0_1px,transparent_1px),linear-gradient(to_bottom,#f0f0f0_1px,transparent_1px)] bg-[size:4rem_4rem]"></div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16" data-aos="fade-up">
                    <h2 class="text-3xl font-bold text-gray-900">Why Choose Us</h2>
                    <p class="mt-4 text-lg text-gray-600">Experience learning like never before</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="p-6 rounded-lg bg-white shadow-sm hover:shadow-md transition duration-150" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Expert-Led Courses</h3>
                        <p class="text-gray-600">Learn from industry professionals with years of experience.</p>
                    </div>
                    <div class="p-6 rounded-lg bg-white shadow-sm hover:shadow-md transition duration-150" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Learn Together</h3>
                        <p class="text-gray-600">Join a community of learners and grow together.</p>
                    </div>
                    <div class="p-6 rounded-lg bg-white shadow-sm hover:shadow-md transition duration-150" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Learn at Your Pace</h3>
                        <p class="text-gray-600">Access course content anytime, anywhere, at your own speed.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-indigo-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">1000+</div>
                        <div class="text-gray-600">Active Students</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">50+</div>
                        <div class="text-gray-600">Expert Instructors</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">100+</div>
                        <div class="text-gray-600">Courses Available</div>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="400">
                        <div class="text-4xl font-bold text-indigo-600 mb-2">95%</div>
                        <div class="text-gray-600">Satisfaction Rate</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-indigo-600 rounded-2xl shadow-xl overflow-hidden" data-aos="fade-up">
                    <div class="px-6 py-12 sm:px-12 sm:py-16">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-white mb-4">Ready to Start Learning?</h2>
                            <p class="text-indigo-100 mb-8 max-w-2xl mx-auto">Join thousands of learners who have already transformed their careers with our courses.</p>
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 transition duration-150">
                                Get Started Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @livewireScripts
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script>
            AOS.init({
                duration: 800,
                once: true
            });
        </script>
    </body>
</html>
