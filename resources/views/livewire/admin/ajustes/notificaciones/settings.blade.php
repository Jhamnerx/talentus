<section class="w-full">
    <h3 class="text-xl leading-snug text-slate-800 font-bold mb-1">General</h3>
    <ul>
        <li class="flex justify-between items-center py-3 border-b border-slate-200">
            <!-- Left -->
            <div>
                <div class="text-slate-800 font-semibold">Comments and replies</div>
                <div class="text-sm">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit.</div>
            </div>
            <!-- Right -->
            <div class="flex items-center ml-4" x-data="{ checked: true }">
                <div class="text-sm text-slate-400 italic mr-2" x-text="checked ? 'On' : 'Off'"></div>
                <div class="form-switch">
                    <input type="checkbox" id="comments" class="sr-only" x-model="checked" />
                    <label class="bg-slate-400" for="comments">
                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                        <span class="sr-only">Enable smart sync</span>
                    </label>
                </div>
            </div>
        </li>
        <li class="flex justify-between items-center py-3 border-b border-slate-200">
            <!-- Left -->
            <div>
                <div class="text-slate-800 font-semibold">Messages</div>
                <div class="text-sm">Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                    deserunt mollit.</div>
            </div>
            <!-- Right -->
            <div class="flex items-center ml-4" x-data="{ checked: true }">
                <div class="text-sm text-slate-400 italic mr-2" x-text="checked ? 'On' : 'Off'"></div>
                <div class="form-switch">
                    <input type="checkbox" id="messages" class="sr-only" x-model="checked" />
                    <label class="bg-slate-400" for="messages">
                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                        <span class="sr-only">Enable smart sync</span>
                    </label>
                </div>
            </div>
        </li>
        <li class="flex justify-between items-center py-3 border-b border-slate-200">
            <!-- Left -->
            <div>
                <div class="text-slate-800 font-semibold">Mentions</div>
                <div class="text-sm">Excepteur sint occaecat cupidatat non in culpa qui officia deserunt mollit.
                </div>
            </div>
            <!-- Right -->
            <div class="flex items-center ml-4" x-data="{ checked: false }">
                <div class="text-sm text-slate-400 italic mr-2" x-text="checked ? 'On' : 'Off'"></div>
                <div class="form-switch">
                    <input type="checkbox" id="mentions" class="sr-only" x-model="checked" />
                    <label class="bg-slate-400" for="mentions">
                        <span class="bg-white shadow-sm" aria-hidden="true"></span>
                        <span class="sr-only">Enable smart sync</span>
                    </label>
                </div>
            </div>
        </li>
    </ul>
    <footer>
        <div class="flex flex-col px-6 py-5 border-t border-slate-200">
            <div class="flex self-end">
                <button class="btn border-slate-200 hover:border-slate-300 text-slate-600">Cancel</button>
                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white ml-3">Save Changes</button>
            </div>
        </div>
    </footer>
</section>
<!-- Panel footer -->