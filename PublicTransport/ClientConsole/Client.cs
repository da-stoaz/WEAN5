namespace ClientConsole;

public class Client
{
    public Client(string baseUrl, HttpClient client)
    {
        client.BaseAddress = new Uri(baseUrl);
        client.Timeout = TimeSpan.FromSeconds(2);
    }
}