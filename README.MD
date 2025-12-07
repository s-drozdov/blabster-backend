# Blabster backend

## Framework choice

At the start, the project has a rather modest budget. It will run for a small audience on k3s on a t3.small, so it absolutely must be compact. There will be no full-fledged database, no clustered cache, and no message broker. Therefore, the main goal is to fit the project into very tight resource limits, so I considered using the Slim framework, as I had always believed it was ideal for ultra-lightweight builds.  

However, practical experience showed that this wasn’t the case. The difference in costs is hardly significant. 

At one point, I was fascinated by micro-framework builds — I tried Lumen and the Yii2 micro edition. Later, I wanted to give Slim a try as well, just to finally close that chapter. But it seems that progress has taken over, and, unfortunately, micro-frameworks are becoming a thing of the past. So using them no longer makes much sense. I hope I'm wrong.  

## Basic bot protection

The project will rely on one-time code delivery for login, so it’s essential to implement a basic set of bot protection measures without compromising the user experience. This will be accomplished through a combination of proof-of-work, environment fingerprinting, and Cloudflare’s “silent” Turnstile CAPTCHA.  
