@php
    $service = request()->query('service', 'dashboard');
@endphp

<x-app-layout>
    <div class="py-6" x-data="{ 
        activeDocSection: 'what-is',
        activeTab: 'curl', 
        telemetryStatus: 'idle', 
        telemetryResult: null, 
        telemetryStatusCode: '',
        querying: false,
        simulateUnauthorized: false,
        
        // Execute sandbox query helper
        runTestQuery(endpoint, params = '') {
            this.querying = true;
            this.telemetryStatus = 'querying';
            this.telemetryStatusCode = '';
            
            let queryUrl = '/dashboard/sandbox-query?endpoint=' + encodeURIComponent(endpoint) + '&params=' + encodeURIComponent(params) + '&unauthorized=' + (this.simulateUnauthorized ? 'true' : 'false');
            
            fetch(queryUrl, {
                headers: {
                    'Accept': 'application/json',
                }
            })
            .then(res => res.json())
            .then(data => {
                this.telemetryResult = JSON.stringify(data.body, null, 4);
                
                let statusText = 'Error';
                if (data.status === 200) statusText = '200 OK';
                else if (data.status === 401) statusText = '401 Unauthorized';
                else if (data.status === 404) statusText = '404 Not Found';
                else if (data.status === 500) statusText = '500 Server Error';
                else statusText = data.status;
                
                this.telemetryStatusCode = 'HTTP ' + statusText;
                this.telemetryStatus = 'success';
                this.querying = false;
            })
            .catch(err => {
                this.telemetryResult = 'Connection failed: ' + err;
                this.telemetryStatus = 'error';
                this.querying = false;
            });
        }
    }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($service === 'dashboard')
                
                <!-- STATE 1: General Dashboard (keseluruhan informasi terkait api key, pemakaian, & request) -->
                <div class="space-y-6">
                    
                    <!-- Analytics Header Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="p-5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm">
                            <div class="text-xs font-semibold text-slate-400 font-mono uppercase tracking-wider">Total Service Queries</div>
                            <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">46,956</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">Aggregated across all service nodes</div>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm">
                            <div class="text-xs font-semibold text-slate-400 font-mono uppercase tracking-wider">Average Latency</div>
                            <div class="text-2xl font-bold text-slate-900 dark:text-white mt-1">1.1ms</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">High availability routing nominal</div>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm">
                            <div class="text-xs font-semibold text-slate-400 font-mono uppercase tracking-wider">Routing Success Rate</div>
                            <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">99.98%</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">0.02% authorization rejects</div>
                        </div>

                        <div class="p-5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm">
                            <div class="text-xs font-semibold text-slate-400 font-mono uppercase tracking-wider">System State</div>
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mt-1">Nominal</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">Service fully operational</div>
                        </div>
                    </div>

                    <!-- Layout: Left Column (Traffic Charts & Key Mgmt) | Right Column (Sandbox Request Boilers) -->
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                        
                        <!-- Left Side: Key Manager and Live Traffic SVG -->
                        <div class="lg:col-span-8 space-y-6">
                            
                            <!-- Traffic Monitoring Curve -->
                            <div class="p-6 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-sm font-bold text-slate-900 dark:text-white">Active Traffic Monitoring</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Exposed API traffic curves over the last 24 hours.</p>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span class="text-[10px] font-mono text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider">Live Analysis</span>
                                    </div>
                                </div>

                                <div class="border rounded-lg bg-slate-50 dark:bg-gray-950 p-4">
                                    <div class="h-28 w-full relative">
                                        <svg class="w-full h-full text-indigo-500" viewBox="0 0 100 30" preserveAspectRatio="none">
                                            <path d="M 0,30 Q 15,10 30,22 T 60,12 T 90,5 T 100,15 L 100,30 L 0,30 Z" fill="currentColor" fill-opacity="0.04" />
                                            <path d="M 0,30 Q 15,10 30,22 T 60,12 T 90,5 T 100,15" fill="none" stroke="currentColor" stroke-width="0.8" />
                                        </svg>
                                        <div class="absolute inset-x-0 bottom-0 flex justify-between text-[9px] font-mono text-slate-400 pt-1 border-t">
                                            <span>24 hours ago</span>
                                            <span>12 hours ago</span>
                                            <span>Just now</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Livewire Token Manager for Key Generation -->
                            <div class="p-6 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm">
                                <livewire:token-manager />
                            </div>

                        </div>

                        <!-- Right Side: Request Guidelines and Sandbox Sandbox -->
                        <div class="lg:col-span-4 space-y-6">
                            
                            <!-- Overall Integration Sandbox -->
                            <div class="p-5 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm space-y-4">
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">How to Perform Requests</h3>
                                    <p class="text-xs text-slate-500 dark:text-gray-400">Copy any integration snippet below and insert it into your client services (e.g. Aksara).</p>
                                </div>

                                <div class="flex items-center gap-2 border-b text-[11px] font-mono text-slate-400 pb-2 overflow-x-auto">
                                    <button @click="activeTab = 'curl'" :class="activeTab === 'curl' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">cURL</button>
                                    <button @click="activeTab = 'php'" :class="activeTab === 'php' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">PHP</button>
                                    <button @click="activeTab = 'js'" :class="activeTab === 'js' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">JS</button>
                                    <button @click="activeTab = 'python'" :class="activeTab === 'python' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">Python</button>
                                    <button @click="activeTab = 'go'" :class="activeTab === 'go' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">Go</button>
                                    <button @click="activeTab = 'ruby'" :class="activeTab === 'ruby' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">Ruby</button>
                                    <button @click="activeTab = 'node'" :class="activeTab === 'node' ? 'text-indigo-600 dark:text-indigo-400 font-bold border-b-2 border-indigo-500 -mb-[9px] pb-2' : ''">Node.js</button>
                                </div>

                                <div class="p-3 bg-slate-50 dark:bg-gray-950 font-mono text-[11px] rounded-lg border border-slate-200 dark:border-gray-800 text-slate-700 dark:text-gray-400 overflow-x-auto min-h-[110px]">
                                    <div x-show="activeTab === 'curl'" x-transition x-cloak class="space-y-1">
                                        <div>curl -X GET "{{ url('/api/v1/geo/provinces') }}" \</div>
                                        <div>  -H "Authorization: Bearer YOUR_TOKEN" \</div>
                                        <div>  -H "Accept: application/json"</div>
                                    </div>
                                    <div x-show="activeTab === 'php'" x-transition x-cloak class="space-y-1">
                                        <div>use Illuminate\Support\Facades\Http;</div>
                                        <br>
                                        <div>$response = Http::withToken('YOUR_TOKEN')</div>
                                        <div>  ->get('{{ url('/api/v1/geo/provinces') }}');</div>
                                    </div>
                                    <div x-show="activeTab === 'js'" x-transition x-cloak class="space-y-1">
                                        <div>fetch('{{ url('/api/v1/geo/provinces') }}', {</div>
                                        <div>  headers: {</div>
                                        <div>    'Authorization': 'Bearer YOUR_TOKEN',</div>
                                        <div>    'Accept': 'application/json'</div>
                                        <div>  }</div>
                                        <div>}).then(res => res.json());</div>
                                    </div>
                                    <div x-show="activeTab === 'python'" x-transition x-cloak class="space-y-1">
                                        <div>import requests</div>
                                        <br>
                                        <div>response = requests.get(</div>
                                        <div>    '{{ url('/api/v1/geo/provinces') }}',</div>
                                        <div>    headers={'Authorization': 'Bearer YOUR_TOKEN'}</div>
                                        <div>)</div>
                                        <div>print(response.json())</div>
                                    </div>
                                    <div x-show="activeTab === 'go'" x-transition x-cloak class="space-y-1">
                                        <div>req, _ := http.NewRequest("GET", "{{ url('/api/v1/geo/provinces') }}", nil)</div>
                                        <div>req.Header.Set("Authorization", "Bearer YOUR_TOKEN")</div>
                                        <div>resp, _ := http.DefaultClient.Do(req)</div>
                                        <div>defer resp.Body.Close()</div>
                                    </div>
                                    <div x-show="activeTab === 'ruby'" x-transition x-cloak class="space-y-1">
                                        <div>require 'net/http'</div>
                                        <div>require 'json'</div>
                                        <br>
                                        <div>uri = URI('{{ url('/api/v1/geo/provinces') }}')</div>
                                        <div>req = Net::HTTP::Get.new(uri)</div>
                                        <div>req['Authorization'] = 'Bearer YOUR_TOKEN'</div>
                                        <div>res = Net::HTTP.start(uri.hostname, uri.port) { |http|</div>
                                        <div>  http.request(req)</div>
                                        <div>}</div>
                                        <div>puts JSON.parse(res.body)</div>
                                    </div>
                                    <div x-show="activeTab === 'node'" x-transition x-cloak class="space-y-1">
                                        <div>const axios = require('axios');</div>
                                        <br>
                                        <div>axios.get('{{ url('/api/v1/geo/provinces') }}', {</div>
                                        <div>  headers: { 'Authorization': 'Bearer YOUR_TOKEN' }</div>
                                        <div>}).then(res => console.log(res.data));</div>
                                    </div>
                                </div>

                                <div class="text-[11px] text-slate-500 leading-relaxed pt-2 border-t">
                                    <strong>Bearer Auth Requirement:</strong> Pass the client token generated under your key desk in the standard <code class="font-mono bg-slate-100 dark:bg-gray-800 p-0.5 rounded text-[10px]">Authorization: Bearer tateta_api_token</code> header format.
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            @else
                
                <!-- STATE 2: Specific Services Documentation (Sidebar on Left | Content on Right) -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left Sidebar (Documentation Navigation) -->
                    <aside class="lg:col-span-3 space-y-4 lg:sticky lg:top-20 z-10">
                        <div class="p-4 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm space-y-4">
                            
                            <div class="px-2 hidden lg:block">
                                @if($service === 'geo')
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Indonesia Geo API</h3>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Administrative Region specs.</p>
                                @elseif($service === 'telemetry')
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">System Health Check</h3>
                                    <p class="text-[10px] text-slate-400 mt-0.5">Service status monitoring.</p>
                                @endif
                            </div>

                            <nav class="flex flex-row overflow-x-auto lg:flex-col gap-1 pb-1 lg:pb-0 scrollbar-none border-b lg:border-0 -mx-4 px-4 lg:mx-0 lg:px-0">
                                <button 
                                    @click="activeDocSection = 'what-is'"
                                    :class="activeDocSection === 'what-is' ? 'bg-indigo-50/60 dark:bg-gray-800 text-indigo-600 dark:text-white font-bold' : 'text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white'"
                                    class="shrink-0 flex items-center gap-2 py-2 px-3.5 text-xs rounded-lg text-left transition duration-150"
                                >
                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                    </svg>
                                    <span>What is?</span>
                                </button>

                                <button 
                                    @click="activeDocSection = 'init'"
                                    :class="activeDocSection === 'init' ? 'bg-indigo-50/60 dark:bg-gray-800 text-indigo-600 dark:text-white font-bold' : 'text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white'"
                                    class="shrink-0 flex items-center gap-2 py-2 px-3.5 text-xs rounded-lg text-left transition duration-150"
                                >
                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.59 14.37a6 6 0 0 1-5.84 7.38v-4.8m5.84-2.58a14.98 14.98 0 0 0 6.16-12.12A14.98 14.98 0 0 0 9.64 4.57a14.96 14.96 0 0 0-7.38 5.84 14.96 14.96 0 0 0 5.84 7.38m8.12-3.42H9.64M18.75 5.25h.008v.008h-.008V5.25Z" />
                                    </svg>
                                    <span>Initialization</span>
                                </button>

                                <button 
                                    @click="activeDocSection = 'setup'"
                                    :class="activeDocSection === 'setup' ? 'bg-indigo-50/60 dark:bg-gray-800 text-indigo-600 dark:text-white font-bold' : 'text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white'"
                                    class="shrink-0 flex items-center gap-2 py-2 px-3.5 text-xs rounded-lg text-left transition duration-150"
                                >
                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    <span>Setup Guide</span>
                                </button>

                                <button 
                                    @click="activeDocSection = 'endpoints'"
                                    :class="activeDocSection === 'endpoints' ? 'bg-indigo-50/60 dark:bg-gray-800 text-indigo-600 dark:text-white font-bold' : 'text-slate-500 dark:text-gray-400 hover:text-slate-900 dark:hover:text-white'"
                                    class="shrink-0 flex items-center gap-2 py-2 px-3.5 text-xs rounded-lg text-left transition duration-150"
                                >
                                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                    </svg>
                                    <span>API Endpoints</span>
                                </button>
                            </nav>

                        </div>
                    </aside>

                    <!-- Right Column (Clicking documentation item displays detailed content here!) -->
                    <main class="lg:col-span-9">
                        <div class="p-6 bg-white dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-xl shadow-sm min-h-[400px]">
                            
                            <!-- Dynamic Content Sections -->
                            
                            <!-- 1. WHAT IS SECTION -->
                            <div x-show="activeDocSection === 'what-is'" x-transition x-cloak class="space-y-4">
                                <h3 class="text-lg font-bold text-slate-950 dark:text-white">What is this Service?</h3>
                                
                                @if($service === 'geo')
                                    <div class="space-y-3 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <p>
                                            The <strong>Indonesia Geo API</strong> is a microservice designed to serve clean, verified spatial and hierarchical administrative records of Indonesia. This includes all <strong>Provinces</strong>, <strong>Regencies</strong>, <strong>Districts</strong>, and <strong>Villages (Kelurahan/Desa)</strong>.
                                        </p>
                                        <p>
                                            It allows developers to offload complex loops or local DB queries from applications (like Aksara) and retrieve accurate, BPS-mapped coordinates and administrative parent structures in less than 2ms.
                                        </p>
                                        <div class="p-4 bg-slate-50 dark:bg-gray-950 rounded-lg border text-xs">
                                            <strong>Key Features:</strong>
                                            <ul class="list-disc pl-5 mt-2 space-y-1">
                                                <li>Official name queries with nested filtering (e.g. search regencies under a specific province ID).</li>
                                                <li>Name-based lookup endpoints to fetch exact IDs without manual database joins.</li>
                                                <li>Highly scalable, cache-backed spatial storage.</li>
                                            </ul>
                                        </div>
                                    </div>
                                @elseif($service === 'telemetry')
                                    <div class="space-y-3 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <p>
                                            The <strong>System Health Check</strong> endpoint provides real-time monitoring of service availability and database connectivity status.
                                        </p>
                                        <p>
                                            It exposes a lightweight, public interface that can be integrated with external monitoring systems (such as UptimeRobot, Prometheus, or Grafana) to trigger automated alerts when connectivity issues occur.
                                        </p>
                                    </div>

                                @endif
                            </div>

                            <!-- 2. INITIALIZATION SECTION -->
                            <div x-show="activeDocSection === 'init'" x-transition x-cloak class="space-y-4">
                                <h3 class="text-lg font-bold text-slate-950 dark:text-white">Initialization & Authentication</h3>
                                
                                @if($service === 'geo')
                                    <div class="space-y-3 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <p>
                                            The Indonesia Geo API endpoints are protected using standard secure token checks. To access the data, you must include your authorization bearer token in every request.
                                        </p>
                                        <div class="space-y-2">
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white uppercase font-mono tracking-wider">Required Header Structure</h4>
                                            <pre class="p-3 bg-slate-50 dark:bg-gray-950 border font-mono rounded text-xs leading-relaxed text-slate-800 dark:text-indigo-400">
Authorization: Bearer <span class="text-slate-400">[YOUR_API_TOKEN]</span>
Accept: application/json</pre>
                                        </div>
                                        <div class="p-3.5 bg-yellow-50 dark:bg-yellow-950/20 border border-yellow-200 dark:border-yellow-900/50 rounded-lg text-xs text-yellow-800 dark:text-yellow-400">
                                            <strong>Warning:</strong> Never commit your plain-text bearer credentials directly to public GitHub repositories. Store them as system environment variables (e.g. <code class="font-mono bg-yellow-100 dark:bg-yellow-900/40 p-0.5 rounded text-[10px]">TATETA_API_KEY</code>).
                                        </div>
                                    </div>
                                @elseif($service === 'telemetry')
                                    <div class="space-y-3 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <p>
                                            The System Telemetry diagnostic endpoints are open and public. No authorization header keys are required to query health parameters.
                                        </p>
                                        <pre class="p-3 bg-slate-50 dark:bg-gray-950 border font-mono rounded text-xs text-slate-800 dark:text-indigo-400">
GET /api/health HTTP/1.1
Accept: application/json</pre>
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500">Service specifications are under operational design.</p>
                                @endif
                            </div>

                            <!-- 3. SETUP GUIDE SECTION -->
                            <div x-show="activeDocSection === 'setup'" x-transition x-cloak class="space-y-4">
                                <h3 class="text-lg font-bold text-slate-950 dark:text-white">Client Setup Guide</h3>
                                
                                @if($service === 'geo')
                                    <div class="space-y-4 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <div class="space-y-2">
                                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">1. Generate Token Key</h4>
                                            <p class="text-xs">Navigate back to the main <a href="{{ route('dashboard', ['service' => 'dashboard']) }}" wire:navigate class="text-indigo-600 hover:underline">Dashboard</a>, input a descriptive device label, and click <strong>Create Token</strong>. Copy the displayed plain-text token.</p>
                                        </div>

                                        <div class="space-y-2">
                                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">2. Paste Into Client Settings</h4>
                                            <p class="text-xs">In your client system (e.g. Aksara), paste the token key under your environment variables file (<code class="font-mono">.env</code>):</p>
                                            <pre class="p-2.5 bg-slate-50 dark:bg-gray-950 border font-mono rounded text-xs text-slate-800 dark:text-indigo-400">TATETA_GEO_TOKEN="tateta_api_token_here"</pre>
                                        </div>

                                        <div class="space-y-2">
                                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-900 dark:text-white">3. Setup Client Service Query</h4>
                                            <p class="text-xs">Invoke the HTTP client helper of your language to perform regional parsing dynamically.</p>
                                        </div>
                                    </div>
                                @elseif($service === 'telemetry')
                                    <div class="space-y-2 text-sm text-slate-600 dark:text-gray-300 leading-relaxed">
                                        <p>Setup queries by registering the public check endpoint in your monitoring console:</p>
                                        <pre class="p-3 bg-slate-50 dark:bg-gray-950 border font-mono rounded text-xs text-slate-800 dark:text-indigo-400">{{ url('/api/health') }}</pre>
                                    </div>
                                @else
                                    <p class="text-sm text-slate-500">Service setup guides are currently under development.</p>
                                @endif
                            </div>

                            <!-- 4. API ENDPOINTS SECTION -->
                            <div x-show="activeDocSection === 'endpoints'" x-transition x-cloak class="space-y-6">
                                <div class="space-y-1">
                                    <h3 class="text-lg font-bold text-slate-950 dark:text-white">Active Endpoint Registry & Sandbox</h3>
                                    <p class="text-xs text-slate-400">Exposed route structures. Click "Query" to simulate client requests in the terminal block below.</p>
                                </div>

                                <!-- Registry Grid -->
                                <div class="overflow-x-auto border rounded-lg">
                                    <table class="min-w-full divide-y divide-slate-100 dark:divide-gray-800">
                                        <thead class="bg-slate-50 dark:bg-gray-950/60">
                                            <tr class="text-[10px] font-bold text-slate-400 uppercase font-mono">
                                                <th class="px-4 py-3 text-left">Method</th>
                                                <th class="px-4 py-3 text-left">Route Path</th>
                                                <th class="px-4 py-3 text-left">Parameters</th>
                                                <th class="px-4 py-3 text-right">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100 dark:divide-gray-800 text-xs font-mono">
                                            @if($service === 'geo')
                                                <!-- Provinces -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/provinces</td>
                                                    <td class="px-4 py-3 text-slate-400 text-[10px]">None</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/provinces')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Provinces Find -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/provinces/find</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?name={string}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/provinces/find', 'name=ACEH')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Regencies -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/regencies</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?province_id={id}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/regencies')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Regencies Find -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/regencies/find</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?name={string}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/regencies/find', 'name=KABUPATEN ACEH SELATAN')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Districts -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/districts</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?regency_id={id}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/districts')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Districts Find -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/districts/find</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?name={string}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/districts/find', 'name=BAKONGAN')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Villages -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/villages</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?district_id={id}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/villages')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                                <!-- Villages Find -->
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/v1/geo/villages/find</td>
                                                    <td class="px-4 py-3 text-indigo-500 text-[10px]">?name={string}</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/v1/geo/villages/find', 'name=KEUDE BAKONGAN')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                            @elseif($service === 'telemetry')
                                                <tr class="hover:bg-slate-50/50 dark:hover:bg-gray-900/30 transition">
                                                    <td class="px-4 py-3"><span class="px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold">GET</span></td>
                                                    <td class="px-4 py-3 text-slate-800 dark:text-slate-200">/api/health</td>
                                                    <td class="px-4 py-3 text-slate-400 text-[10px]">None</td>
                                                    <td class="px-4 py-3 text-right">
                                                        <button @click="runTestQuery('/api/health')" class="px-2.5 py-1 bg-slate-100 hover:bg-indigo-500 hover:text-white text-slate-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-indigo-600 rounded text-[10px] font-sans font-semibold transition">Query</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Dynamic Response Block -->
                                <div class="space-y-2 pt-4 border-t border-slate-100 dark:border-gray-800">
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs font-mono">
                                        <div class="flex items-center gap-4">
                                            <span class="text-slate-400 font-semibold">Response Terminal</span>
                                            <label class="inline-flex items-center gap-1.5 cursor-pointer select-none text-[10px] text-slate-500 hover:text-slate-700 dark:text-gray-400 dark:hover:text-gray-300">
                                                <input type="checkbox" x-model="simulateUnauthorized" class="rounded border-slate-300 dark:border-gray-800 dark:bg-gray-950 text-indigo-600 focus:ring-indigo-500 focus:ring-0 focus:ring-offset-0 size-3" />
                                                <span>Simulate 401 Unauthorized</span>
                                            </label>
                                        </div>
                                        <span :class="telemetryStatus === 'success' ? (telemetryStatusCode.includes('200') ? 'text-emerald-500 dark:text-emerald-400 font-bold' : 'text-red-500 font-bold') : 'text-slate-400'" class="font-bold">
                                            <span x-text="telemetryStatus === 'success' ? telemetryStatusCode : (telemetryStatus === 'querying' ? 'CONNECTING...' : 'IDLE')"></span>
                                        </span>
                                    </div>
                                    <div class="p-4 bg-slate-50 dark:bg-gray-950 font-mono text-[11px] rounded-lg border border-slate-200 dark:border-gray-800 min-h-[120px] max-h-[300px] overflow-y-auto">
                                        <template x-if="telemetryStatus === 'idle'">
                                            <div class="text-slate-400 italic">No query triggered yet. Click "Query" in the registry table above to run live tests.</div>
                                        </template>
                                        <template x-if="telemetryStatus === 'querying'">
                                            <div class="text-indigo-500 animate-pulse">GET request routing... Connecting to operational database tables...</div>
                                        </template>
                                        <template x-if="telemetryStatus === 'success'">
                                            <pre class="whitespace-pre-wrap select-all text-slate-800 dark:text-gray-300" x-text="telemetryResult"></pre>
                                        </template>
                                        <template x-if="telemetryStatus === 'error'">
                                            <pre class="text-red-500" x-text="telemetryResult"></pre>
                                        </template>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </main>

                </div>

            @endif

        </div>
    </div>
</x-app-layout>
