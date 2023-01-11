<div>
    <div
        class="w-full fixed md:w-2/3 lg:w-1/2 md:top-[50%] md:left-[50%] md:-translate-x-1/2 md:-translate-y-1/2 p-5 bg-white shadow-2xl rounded-2xl">
        <div class="flex items-center space-x-5">
            <img src="{{ asset('assets/images/logo.png') }}" class="w-12"/>
            <p class="text-[24px] font-semibold text-center text-gray-700">Генератор коротких посилань</p>
        </div>
        @if(!empty($shortURL))
        <div class="w-full h-10 items-center">
            <div class="transition-all duration-500 ease-out -translate-y-1 text-green-600 text-center w-full"
                 id="tooltip"></div>
        </div>
        <div class="bg-gray-100 p-5 rounded-xl text-center select-all" id="shortUrl"
             onclick="copyToClipboard()">{{ $shortURL }}</div>
        @endif
        <div class="mt-6 w-full mx-auto">
            @if(!empty($error))
                <div class="w-full mb-5 p-2 text-red-500 text-center">{{ $error }}</div>
            @endif
            <div class="space-y-3">
                <label for="destination" class="text-[14px] text-gray-700">Введіть посилання, яке потрібно
                    скоротити</label>
                <input wire:model="destination" type="text" id="destination" name="destination"
                       class="outline-none bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                       placeholder="https://med.krayina.com/wallet/12345678">
            </div>
            <div
                class="mt-5 space-y-7 lg:space-y-0 lg:gap-5 lg:flex-row-reverse  lg:flex lg:justify-between lg:items-center">
                <div wire:click="generate"
                     class="text-center text-white w-full bg-red-500 font-medium rounded-lg text-sm px-5 py-2.5 cursor-pointer">
                    Скоротити
                </div>
                <div wire:click="toggleOptions"
                     class="text-center text-white w-full bg-indigo-500 font-medium rounded-lg text-sm px-5 py-2.5 cursor-pointer">
                    Розширені налаштування
                </div>
            </div>
            @if($isOpened)
                <div class="rounded-xl border p-5 mt-5 transition duration-1000 ease-in transform space-y-5">
                    <div class="flex items-center">
                        <input wire:model="singleUse" id="singleUse" type="checkbox"
                               class="w-5 h-5 text-red-500 border-gray-700 rounded focus:ring-blue-500">
                        <label for="singleUse" class="select-none ml-2 text-sm font-medium text-gray-700">Одноразове
                            посилання</label>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input wire:model="deactivateAt" id="deactivateAt" type="checkbox"
                               class="w-5 h-5 text-red-500 border-gray-700 rounded focus:ring-blue-500">
                        <label for="deactivateAt" class="select-none ml-2 text-sm font-medium text-gray-700">Деактивація
                            посилання через</label>
                        <input wire:model="deactivateAtCount"
                               class="outline-none w-10 text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-1"/>
                        <select wire:model="deactivateAtType"
                                class="outline-none focus:ring-0 focus:border-1 w-20 text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block p-1">
                            <option value="0" selected>День</option>
                            <option value="1">Місяць</option>
                            <option value="2">Рік</option>
                        </select>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        function copyToClipboard() {
            let shortURL = document.getElementById('shortUrl').innerText;
            navigator.clipboard.writeText(shortURL);
            let tooltip = document.getElementById('tooltip');
            tooltip.innerText = 'Скопійовано!';
            tooltip.classList.add('translate-y-1')
        }
    </script>
</div>
