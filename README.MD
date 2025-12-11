# Blabster backend

## Framework choice

At the start, the project has a rather modest budget. It will run for a small audience on k3s on a t3.small, so it absolutely must be compact. There will be no full-fledged database, no clustered cache, and no message broker. Therefore, the main goal is to fit the project into very tight resource limits, so I considered using the Slim framework, as I had always believed it was ideal for ultra-lightweight builds.  

However, practical experience showed that this wasn’t the case. The difference in costs is hardly significant. 

At one point, I was fascinated by micro-framework builds — I tried Lumen and the Yii2 micro edition. Later, I wanted to give Slim a try as well, just to finally close that chapter. But it seems that progress has taken over, and, unfortunately, micro-frameworks are becoming a thing of the past. So using them no longer makes much sense. I hope I'm wrong.  

## Basic bot protection

The project will rely on one-time code delivery for login, so it’s essential to implement a basic set of bot protection measures without compromising the user experience. This will be accomplished through a combination of proof-of-work, environment fingerprinting, and Cloudflare’s “silent” Turnstile CAPTCHA.  

## OTP Sign in

### Frontend

When a user visits the site without a valid token, they are redirected to the authentication page.  
On this page, the user fills out a form containing a single email input. Then the email is validated on the frontend using a simple regex.

If the email is valid, proceed and activate isLoading state for spinners.

Next steps:

1. Run the Proof-of-Work challenge: send a POST request to /challenge, receive the task, compute the solution, and store the result for the upcoming /otp request.
2. Compute the device fingerprint (FingerprintJS) and store it for the /otp request.
3. Complete the Turnstile challenge and obtain the Turnstile token.

We then assemble the payload containing:

- email
- PoW result
- fingerprint
- turnstile token

And send it to /otp.

### Backend

#### /otp

Validate the PoW result. If missing or invalid — return an error.
Validate the Turnstile token via the Cloudflare API.
Check whether there is an existing cache entry for given fingerprint value.

If it exists, return 429 along with the remaining TTL.
On the frontend, start a countdown timer based on the TTL.

If everything is valid:
- Generate an OTP and store it in the cache with a 10-minute TTL (otp:<email>).
- Send the OTP to the user.
- Respond with 202 and the email.

The user receives the 202 response and email and is redirected to the OTP entry page. They may enter the OTP or navigate back.

When the user enters the OTP, the frontend sends { email, otp } to /login.

#### /login

Look up the OTP entry in the cache.

If not found — return 401.

If found — delete it from the cache, register or log in the user, return an access JWT, and set a refresh token in an http-only cookie.

After that, everything proceeds as usual.

PoW challenges, OTPs, and fingerprints are all stored in the cache.
