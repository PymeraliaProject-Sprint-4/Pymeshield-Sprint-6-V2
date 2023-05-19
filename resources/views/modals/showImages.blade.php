
<div data-modal-backdrop="static" id="showImages" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Imágenes
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="showImages">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Cerrar</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <swiper-container 
                    navigation="true"
                    pagination="true" pagination-clickable="true"
                    loop="true"
                    class="w-full h-60">
                
                @foreach ($files as $file)

                <swiper-slide class="flex align-center justify-center flex-none">
                    <a href="{{asset($file->location)}}" target="_blank" class="flex align-center justify-center flex-none">
                        <img src="{{asset($file->location)}}" alt="image" class="h-full rounded-md object-cover">
                    </a>
                </swiper-slide>
                
                @endforeach
            </swiper-container>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="showImages" data-modal-target="addImages" data-modal-toggle="addImages" class="bg-orange-500 hover:bg-orange-400 block text-white focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 mt-3 text-center" type="button">
                    Añadir imágenes
                </button>
                <button data-modal-hide="showImages" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cerrar</button>
            </div>
        </div>
    </div>
</div>
