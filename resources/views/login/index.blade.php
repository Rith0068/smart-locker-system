
   <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Card</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f7] min-h-screen flex items-center justify-center p-4 font-sans">


  <div class="bg-white rounded-2xl border border-gray-200 p-8 w-[440px] max-w-full shadow-sm">
    
    
    <nav class="bg-[#eef0eb] p-1.5 rounded-xl flex mb-6">
      <a href="login.html" class="flex-1 py-2.5 text-center font-bold text-[#2b3a55] text-base bg-white rounded-lg shadow-sm">
        Log in
      </a>
      <a href="create-account.html" class="flex-1 py-2.5 text-center font-bold text-[#4a5568] text-base rounded-lg hover:text-black transition-colors">
        Create account
      </a>
    </nav>

    
    <form class="space-y-5" onsubmit="event.preventDefault();">
      
      <div>
        <label for="email" class="block font-bold text-[#4a5568] mb-2 text-sm">
          Email
        </label>
        <input 
          type="email" 
          id="email" 
          value="email"
          class="w-full bg-[#fefde8] border border-[#e2e8f0] rounded-xl px-4 py-3 text-[#1a202c] font-medium text-base focus:outline-none focus:ring-2 focus:ring-emerald-700"
        />
      </div>

   
      <div>
        <label for="password" class="block font-bold text-[#4a5568] mb-2 text-sm">
          Password
        </label>
        <input 
          type="password" 
          id="password" 
          value="password"
          class="w-full bg-[#fefde8] border border-[#e2e8f0] rounded-xl px-4 py-3 text-[#1a202c] font-medium text-base focus:outline-none focus:ring-2 focus:ring-emerald-700"
        />
      </div>

      <button 
        type="submit" 
        class="w-full bg-[#2a594e] hover:bg-[#21473e] text-white font-bold py-3.5 px-4 rounded-xl text-base transition-colors"
      >
        Log in
      </button>
    </form>

    

  </div>

</body>
</html>
