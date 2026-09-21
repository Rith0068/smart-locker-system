<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Account</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f5f5f7] min-h-screen flex items-center justify-center p-4 font-sans">

  <div class="bg-white rounded-2xl border border-gray-200 p-8 w-[440px] max-w-full shadow-sm">
  
    <nav class="bg-[#eef0eb] p-1.5 rounded-xl flex mb-6">
      <a href="login.html" class="flex-1 py-2.5 text-center font-bold text-[#4a5568] text-base rounded-lg hover:text-black transition-colors">
        Log in
      </a>
      <a href="create-account.html" class="flex-1 py-2.5 text-center font-bold text-[#2b3a55] text-base bg-white rounded-lg shadow-sm">
        Create account
      </a>
    </nav>

  
    <form class="space-y-4" onsubmit="event.preventDefault();">
     
      <div>
        <label for="name" class="block font-bold text-[#4a5568] mb-1.5 text-sm">
          Full Name
        </label>
        <input 
          type="text" 
          id="name" 
          placeholder="Jane Doe"
          class="w-full bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-4 py-3 text-[#1a202c] font-medium text-base focus:outline-none focus:bg-white focus:border-[#2a594e] focus:ring-1 focus:ring-[#2a594e]"
        />
      </div>

     
      <div>
        <label for="email" class="block font-bold text-[#4a5568] mb-1.5 text-sm">
          Email
        </label>
        <input 
          type="email" 
          id="email" 
          placeholder="jane@example.com"
          class="w-full bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-4 py-3 text-[#1a202c] font-medium text-base focus:outline-none focus:bg-white focus:border-[#2a594e] focus:ring-1 focus:ring-[#2a594e]"
        />
      </div>

     
      <div>
        <label for="password" class="block font-bold text-[#4a5568] mb-1.5 text-sm">
          Password
        </label>
        <input 
          type="password" 
          id="password" 
          placeholder="••••••••"
          class="w-full bg-[#f8fafc] border border-[#e2e8f0] rounded-xl px-4 py-3 text-[#1a202c] font-medium text-base focus:outline-none focus:bg-white focus:border-[#2a594e] focus:ring-1 focus:ring-[#2a594e]"
        />
      </div>

      <button 
        type="submit" 
        class="w-full bg-[#2a594e] hover:bg-[#21473e] text-white font-bold py-3.5 px-4 rounded-xl text-base transition-colors mt-2"
      >
        Create account
      </button>
    </form>

   
    <div class="mt-6 space-y-1 text-xs text-[#64748b]">
      <p>
        By creating an account, you agree to our <span class="font-bold text-[#334155] underline cursor-pointer">Terms of Service</span>.
      </p>
    </div>

  </div>

</body>
</html>