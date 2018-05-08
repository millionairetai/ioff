appRoot.factory('socketService', ['socketFactory', function (socketFactory) {

        var myIoSocket = io.connect('http://company.iofficez.dev:3000');
        mySocket = socketFactory({
            ioSocket: myIoSocket
        });
        return mySocket;
    }]);

