from colorama import Fore, Back, Style
import subprocess, json, time, hashlib, socket

def get_network_ip():
    """Helper to find the actual IP address of this machine on the Wi-Fi/Ethernet."""
    s = socket.socket(socket.AF_INET, socket.SOCK_DGRAM)
    try:
        # Doesn't need to connect, just triggers interface selection
        s.connect(('8.8.8.8', 1))
        IP = s.getsockname()[0]
    except Exception:
        IP = '127.0.0.1'
    finally:
        s.close()
    return IP

def kill_php_proc():
    with open("storm-web/Settings.json", "r") as jsonFile:
        data = json.load(jsonFile)
        pid = data["pid"]

    try:
        for i in pid:
            subprocess.getoutput(f"kill -9 {i}")
        
        pid.clear()
        data["pid"] = []
        with open("storm-web/Settings.json", "w") as jsonFile:
            json.dump(data, jsonFile)
    except:
        pass

def md5_hash():
    str2hash = time.strftime("%Y-%m-%d-%H:%M", time.gmtime())
    result = hashlib.md5(str2hash.encode())
    return result

def run_php_server(port):
    # Get the real IP for display purposes
    network_ip = get_network_ip()

    with open(f"storm-web/log/php-{md5_hash().hexdigest()}.log","w") as php_log:
        # --- CHANGE: Changed localhost to 0.0.0.0 so it listens to the network ---
        proc_info = subprocess.Popen(("php", "-S", f"0.0.0.0:{port}", "-t", "storm-web"), stderr=php_log, stdout=php_log).pid

    with open("storm-web/Settings.json", "r") as jsonFile:
        data = json.load(jsonFile)
        data["pid"].append(proc_info)

    with open("storm-web/Settings.json", "w") as jsonFile:
        json.dump(data, jsonFile)

    # --- UPDATED DISPLAY ---
    print(Fore.RED + " [+] " + Fore.GREEN + "Local Panel Link   : " + Fore.WHITE + f"http://localhost:{port}")
    print(Fore.RED + " [+] " + Fore.GREEN + "Network Panel Link : " + Fore.WHITE + f"http://{network_ip}:{port}")
    print(Fore.RED + "\n [+] " + Fore.LIGHTCYAN_EX + f"Please Run NGROK On Port {port} AND Send Link To Target > " + Fore.YELLOW + Back.BLACK + f"ngrok http {port}\n" + Style.RESET_ALL)