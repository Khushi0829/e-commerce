<?php
session_start();

// ✅ load DB connection
require_once __DIR__ . '/../config/db.php';

 // ✅ load header (BASE_URL etc)
 require_once __DIR__ . '/../includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Support</title>

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <!-- Font Awesome -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/master.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="customer-care-container">

        <!-- Header -->
        <div class="cc-header">
            <h2>Customer Support <i class="fa-solid fa-handshake"></i></h2>
            <p>We are here to help you 24×7</p>
        </div>

        <div class="cc-grid">


            <!-- LEFT: Chatbot -->

            <div class="cc-chatbox ">
                <div class="chat-header">Live Chat <i class="fa-solid fa-message-bot"></i></div>
                <div class="chat-body" id="chatBody"></div>

                <div class="chat-input">
                    <input type="text" id="chatInput" placeholder="Type your message...">
                    <button onclick="sendChat()">Send</button>
                </div>
            </div>


            <!-- RIGHT: Support Options -->

            <div class="cc-support">

                <!-- Quick Help -->
                <div class="cc-card">
                    <h4>Quick Help <i class="fa-solid fa-bolt-lightning"></i></h4>
                    <ul>
                        <li onclick="autoMessage('Where is my order?')"><i class="fa-solid fa-box"></i>
                            Track My
                            Order</li>
                        <li onclick="autoMessage('Return policy')"><i class="fa-solid fa-arrows-rotate"></i>
                            Return
                            & Refund</li>
                        <li onclick="autoMessage('Payment issue')"><i class="fa-solid fa-credit-card"></i>
                            Payment
                            Issue</li>
                        <li onclick="autoMessage('Contact support')"><i class="fa-solid fa-phone"></i>
                            Contact
                            Support</li>
                    </ul>
                </div>

                <!-- Contact Options -->
                <div class="cc-card">
                    <h4>Contact Us <i class="fa-solid fa-phone"></i></h4>
                    <div class="cc-contact">
                        <a href="tel:+919999999999"><i class="fa-solid fa-phone"></i> Call Us</a>
                        <a href="mailto:support@yourwebsite.com"><i class="fa-solid fa-envelope"></i>
                            Email</a>
                        <a href="https://wa.me/919999999999" target="_blank"><i class="fa-brands fa-whatsapp"></i>
                            WhatsApp</a>
                    </div>
                </div>

            </div>


        </div>

    </div>

    <?php include "../includes/footer.php"; ?>

    <script>
        const chatBody = document.getElementById("chatBody");
        const chatInput = document.getElementById("chatInput");

        // ✅ Add message to UI
        function addMessage(text, type = "user") {
            const msgDiv = document.createElement("div");
            msgDiv.className = "chat-msg " + type;
            msgDiv.innerText = text;
            chatBody.appendChild(msgDiv);
            chatBody.scrollTop = chatBody.scrollHeight;
        }

        // ✅ Send chat message
        function sendChat() {
            let message = chatInput.value.trim();
            if (message === "") return;

            // Show user message
            addMessage(message, "user");
            chatInput.value = "";

            // Send to PHP backend
            fetch("chat-send.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ message: message })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.reply) {
                        addMessage(data.reply, "bot");
                    } else {
                        addMessage("🤖 Sorry, I didn't understand.", "bot");
                    }
                })
                .catch(err => {
                    console.error(err);
                    addMessage("⚠️ Server error. Try again.", "bot");
                });
        }

        // ✅ Quick auto messages (right side clicks)
        function autoMessage(text) {
            chatInput.value = text;
            sendChat();
        }

        // ✅ Enter key support
        chatInput.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                sendChat();
            }
        });

        // ✅ Load old chats (optional)
        function loadChats() {
            fetch("chat-load.php")
                .then(res => res.json())
                .then(data => {
                    chatBody.innerHTML = "";

                    let hasMessages = data.length > 0;

                    data.forEach(chat => {
                        addMessage(chat.message, chat.sender === "bot" ? "bot" : "user");
                    });
                    // ✅ Show greeting ONLY if no messages exist
                    if (!hasMessages) {
                        addMessage("👋 Hello! How can I help you today?", "bot");
                    }
                })
                .catch(err => console.error(err));
        }

        // ✅ Load chats on page load
        loadChats();
    </script>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

    <!-- --------------AOS JS---------- -->

    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 500,
            easing: 'ease-out-cubic',
            once: true,          // animation runs once
            offset: 120          // triggers slightly before visible
        });
    </script>





    <!-- script js -->
    <script src="../assets/js/script.js"></script>


</body>

</html>