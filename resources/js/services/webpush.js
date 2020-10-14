const WebPush = {
  permissionState: null,
  hasBrowserSupport() {
    return ('serviceWorker' in navigator) && ('PushManager' in window);
  },
  registerServiceWorker(file) {
    return navigator.serviceWorker.register(file)
    .then(function(registration) {
      return registration;
    })
    .catch(function(err) {
      console.error('Unable to register service worker.', err);
    });
  },
  getNotificationPermissionState() {
    if ( this.permissionState !== null ) {
      return new Promise((resolve) => {
        resolve(this.permissionState);
      });
    }

    if (navigator.permissions) {
      return navigator.permissions.query({name: 'notifications'})
      .then((result) => {
        this.permissionState = result.state;
        return result.state;
      });
    }

    return new Promise((resolve) => {
      this.permissionState = Notification.permission;
      resolve(Notification.permission);
    });
  },
  permissionIsGranted(state) {
    return state === 'granted';
  },
  askPermission() {
    return new Promise(function(resolve, reject) {
      const permissionResult = Notification.requestPermission(function(result) {
        resolve(result);
      });

      if (permissionResult) {
        permissionResult.then(resolve, reject);
      }
    });
  },
  showNotification(title, options) {
    this.getNotificationPermissionState().then((state) => {
     if ( state === 'granted' ) {
        navigator.serviceWorker.getRegistration().then((req) => req.showNotification(title, options));
     };
    })
  }
}

export default WebPush;
