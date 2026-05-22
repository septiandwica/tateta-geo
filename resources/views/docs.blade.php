<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>API Documentation - TatetaGeo</title>
        <meta name="description" content="Complete API documentation for TatetaGeo - Indonesian regional data service">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white dark:bg-gray-950 text-slate-900 dark:text-gray-100">
        <div class="flex min-h-screen">
            <!-- Sidebar Navigation -->
            <aside class="hidden lg:block w-64 bg-slate-50 dark:bg-gray-900 border-r border-slate-200 dark:border-gray-800 sticky top-0 h-screen overflow-y-auto">
                <div class="p-6">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-6">Documentation</h2>
                    <nav class="space-y-1">
                        <a href="#getting-started" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Getting Started</a>
                        <a href="#authentication" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Authentication</a>
                        <a href="#base-url" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Base URL</a>
                        <a href="#endpoints" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Endpoints</a>
                        <a href="#request-parameters" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Request Parameters</a>
                        <a href="#response-format" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Response Format</a>
                        <a href="#error-handling" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Error Handling</a>
                        <a href="#code-examples" class="block px-3 py-2 rounded-lg text-sm font-medium text-slate-700 dark:text-gray-300 hover:bg-slate-200 dark:hover:bg-gray-800 transition">Code Examples</a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1">
                <!-- Header -->
                <header class="border-b border-slate-200 dark:border-gray-800 bg-white dark:bg-gray-950 sticky top-0 z-40">
                    <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">API Documentation</h1>
                            <p class="text-sm text-slate-600 dark:text-gray-400">TatetaGeo - Indonesian Regional Data Service</p>
                        </div>
                        <a href="/" class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300">← Back to Home</a>
                    </div>
                </header>

                <!-- Content -->
                <div class="max-w-4xl mx-auto px-6 py-12 space-y-16">
                    <!-- Getting Started -->
                    <section id="getting-started" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Getting Started</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            TatetaGeo API provides access to comprehensive Indonesian regional data including provinces, regencies, districts, and villages. All endpoints require authentication using a Bearer token.
                        </p>
                        <div class="bg-indigo-50 dark:bg-indigo-500/10 border border-indigo-200 dark:border-indigo-500/20 rounded-lg p-4 mb-6">
                            <p class="text-sm text-indigo-900 dark:text-indigo-200">
                                <strong>Base URL:</strong> <code class="bg-white dark:bg-gray-900 px-2 py-1 rounded text-xs font-mono">https://your-domain.com/api/v1/geo</code>
                            </p>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Quick Start</h3>
                        <ol class="list-decimal list-inside space-y-2 text-slate-600 dark:text-gray-400">
                            <li>Sign up and validate your email</li>
                            <li>Get your API token from the dashboard</li>
                            <li>Include the token in your requests as a Bearer token</li>
                            <li>Start querying regional data</li>
                        </ol>
                    </section>

                    <!-- Authentication -->
                    <section id="authentication" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Authentication</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            All API requests require authentication using a Bearer token. After signing up and validating your email, you can find your API token in your dashboard.
                        </p>
                        
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Using Your API Token</h3>
                        <p class="text-slate-600 dark:text-gray-400 mb-4">
                            Include your token in the <code class="bg-slate-100 dark:bg-gray-800 px-2 py-1 rounded text-xs font-mono">Authorization</code> header:
                        </p>
                        
                        <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 mb-6 overflow-x-auto">
                            <pre class="text-slate-100 text-sm font-mono"><code>Authorization: Bearer YOUR_API_TOKEN</code></pre>
                        </div>

                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Example Request</h3>
                        <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                            <pre class="text-slate-100 text-sm font-mono"><code>curl -X GET "https://your-domain.com/api/v1/geo/provinces" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Accept: application/json"</code></pre>
                        </div>
                    </section>

                    <!-- Base URL -->
                    <section id="base-url" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Base URL & Versioning</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            All API endpoints are prefixed with the base URL and API version. The current version is <code class="bg-slate-100 dark:bg-gray-800 px-2 py-1 rounded text-xs font-mono">v1</code>.
                        </p>
                        
                        <div class="bg-slate-50 dark:bg-gray-900 border border-slate-200 dark:border-gray-800 rounded-lg p-4">
                            <p class="text-slate-900 dark:text-white font-mono text-sm">
                                <span class="text-slate-600 dark:text-gray-400">Base URL:</span> https://your-domain.com/api/v1/geo
                            </p>
                        </div>
                    </section>

                    <!-- Endpoints -->
                    <section id="endpoints" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Endpoints</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            TatetaGeo provides endpoints for querying provinces, regencies, districts, and villages. All endpoints require authentication.
                        </p>

                        <div class="space-y-6">
                            <!-- Provinces -->
                            <div class="border border-slate-200 dark:border-gray-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Provinces</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /provinces</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">List all provinces in Indonesia</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /provinces/find</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">Find a specific province by ID or name</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Regencies -->
                            <div class="border border-slate-200 dark:border-gray-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Regencies</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /regencies</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">List all regencies in Indonesia</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /regencies/find</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">Find a specific regency by ID or name</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Districts -->
                            <div class="border border-slate-200 dark:border-gray-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Districts</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /districts</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">List all districts in Indonesia</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /districts/find</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">Find a specific district by ID or name</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Villages -->
                            <div class="border border-slate-200 dark:border-gray-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Villages</h3>
                                <div class="space-y-3">
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /villages</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">List all villages in Indonesia</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-mono text-indigo-600 dark:text-indigo-400 mb-1">GET /villages/find</p>
                                        <p class="text-sm text-slate-600 dark:text-gray-400">Find a specific village by ID or name</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Request Parameters -->
                    <section id="request-parameters" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Request Parameters</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            Common query parameters supported across endpoints:
                        </p>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full border border-slate-200 dark:border-gray-800 rounded-lg">
                                <thead class="bg-slate-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase tracking-wider">Parameter</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase tracking-wider">Type</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase tracking-wider">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400">id</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">string</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Filter by specific ID</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400">name</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">string</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Search by name (partial match)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400">province_id</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">string</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Filter by province (for regencies, districts, villages)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400">regency_id</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">string</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Filter by regency (for districts, villages)</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-indigo-600 dark:text-indigo-400">district_id</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">string</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Filter by district (for villages)</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Response Format -->
                    <section id="response-format" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Response Format</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            All successful responses return JSON with the following structure:
                        </p>
                        
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Success Response</h3>
                        <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 mb-6 overflow-x-auto">
                            <pre class="text-slate-100 text-sm font-mono"><code>{
  "success": true,
  "data": [
    {
      "id": "31",
      "name": "DKI JAKARTA"
    },
    {
      "id": "32",
      "name": "JAWA BARAT"
    }
  ]
}</code></pre>
                        </div>

                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Response Properties</h3>
                        <div class="space-y-3">
                            <div class="border-l-4 border-indigo-500 pl-4">
                                <p class="text-sm font-mono text-slate-900 dark:text-white">success</p>
                                <p class="text-sm text-slate-600 dark:text-gray-400">Boolean indicating if the request was successful</p>
                            </div>
                            <div class="border-l-4 border-indigo-500 pl-4">
                                <p class="text-sm font-mono text-slate-900 dark:text-white">data</p>
                                <p class="text-sm text-slate-600 dark:text-gray-400">Array of objects containing the requested regional data</p>
                            </div>
                        </div>
                    </section>

                    <!-- Error Handling -->
                    <section id="error-handling" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Error Handling</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            When an error occurs, the API returns a JSON response with error details:
                        </p>
                        
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Error Response</h3>
                        <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 mb-6 overflow-x-auto">
                            <pre class="text-slate-100 text-sm font-mono"><code>{
  "success": false,
  "message": "Unauthenticated.",
  "error": {
    "code": 401,
    "type": "AuthenticationError"
  }
}</code></pre>
                        </div>

                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">HTTP Status Codes</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full border border-slate-200 dark:border-gray-800 rounded-lg">
                                <thead class="bg-slate-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase tracking-wider">Code</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-slate-900 dark:text-white uppercase tracking-wider">Description</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-200 dark:divide-gray-800">
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-emerald-600 dark:text-emerald-400">200</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Success - Request completed successfully</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-red-600 dark:text-red-400">400</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Bad Request - Invalid request parameters</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-red-600 dark:text-red-400">401</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Unauthorized - Missing or invalid API token</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-red-600 dark:text-red-400">404</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Not Found - Resource not found</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-red-600 dark:text-red-400">429</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Too Many Requests - Rate limit exceeded</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-mono text-red-600 dark:text-red-400">500</td>
                                        <td class="px-4 py-3 text-sm text-slate-600 dark:text-gray-400">Internal Server Error - Server error occurred</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>

                    <!-- Code Examples -->
                    <section id="code-examples" class="scroll-mt-20">
                        <h2 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Code Examples</h2>
                        <p class="text-slate-600 dark:text-gray-400 mb-6">
                            Here are examples of how to use the TatetaGeo API in different programming languages:
                        </p>

                        <!-- cURL -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">cURL</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>curl -X GET "https://your-domain.com/api/v1/geo/provinces" \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Accept: application/json"</code></pre>
                            </div>
                        </div>

                        <!-- PHP -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">PHP (Laravel HTTP Client)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>&lt;?php

use Illuminate\Support\Facades\Http;

$response = Http::withToken('YOUR_API_TOKEN')
    ->timeout(2)
    ->get('https://your-domain.com/api/v1/geo/provinces');

$data = $response->json();
print_r($data);</code></pre>
                            </div>
                        </div>

                        <!-- Python -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Python (Requests)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>import requests

url = "https://your-domain.com/api/v1/geo/provinces"
headers = {
    "Authorization": "Bearer YOUR_API_TOKEN",
    "Accept": "application/json"
}

response = requests.get(url, headers=headers)
data = response.json()
print(data)</code></pre>
                            </div>
                        </div>

                        <!-- JavaScript -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">JavaScript (Fetch API)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>fetch('https://your-domain.com/api/v1/geo/provinces', {
  headers: {
    'Authorization': 'Bearer YOUR_API_TOKEN',
    'Accept': 'application/json'
  }
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));</code></pre>
                            </div>
                        </div>

                        <!-- Node.js -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Node.js (Axios)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>const axios = require('axios');

axios.get('https://your-domain.com/api/v1/geo/provinces', {
  headers: {
    'Authorization': 'Bearer YOUR_API_TOKEN',
    'Accept': 'application/json'
  }
})
.then(response => console.log(response.data))
.catch(error => console.error('Error:', error));</code></pre>
                            </div>
                        </div>

                        <!-- Go -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Go (net/http)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>package main

import (
    "fmt"
    "io/ioutil"
    "net/http"
)

func main() {
    url := "https://your-domain.com/api/v1/geo/provinces"
    
    req, _ := http.NewRequest("GET", url, nil)
    req.Header.Set("Authorization", "Bearer YOUR_API_TOKEN")
    req.Header.Set("Accept", "application/json")
    
    client := &http.Client{}
    resp, _ := client.Do(req)
    defer resp.Body.Close()
    
    body, _ := ioutil.ReadAll(resp.Body)
    fmt.Println(string(body))
}</code></pre>
                            </div>
                        </div>

                        <!-- Ruby -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-3">Ruby (net/http)</h3>
                            <div class="bg-slate-900 dark:bg-gray-950 rounded-lg p-4 overflow-x-auto">
                                <pre class="text-slate-100 text-sm font-mono"><code>require 'net/http'
require 'json'

uri = URI('https://your-domain.com/api/v1/geo/provinces')
req = Net::HTTP::Get.new(uri)
req['Authorization'] = 'Bearer YOUR_API_TOKEN'
req['Accept'] = 'application/json'

res = Net::HTTP.start(uri.hostname, uri.port, use_ssl: true) do |http|
  http.request(req)
end

data = JSON.parse(res.body)
puts data</code></pre>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Footer -->
                <footer class="border-t border-slate-200 dark:border-gray-800 mt-16">
                    <div class="max-w-4xl mx-auto px-6 py-8">
                        <p class="text-sm text-slate-600 dark:text-gray-400 text-center">
                            © {{ date('Y') }} TatetaGeo. All rights reserved.
                        </p>
                    </div>
                </footer>
            </main>
        </div>
    </body>
</html>
