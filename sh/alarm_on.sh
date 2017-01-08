vcgencmd display_power 1

# Required env var for chromium to launch in the Pi's display
export DISPLAY=":0"

# This line changes the config to avoid chromium poping a message if it didn't exit cleanly
set -i 's/"exited_cleanly": false/"exited_cleanly": true/' ~/.config/chromium-browser/Default/Preferences

chromium-browser --disable-extensions --noerrdialogs --disable-infobars --kiosk --no-first-run --incognito http://localhost/view.php > /dev/null 2>/dev/null &
