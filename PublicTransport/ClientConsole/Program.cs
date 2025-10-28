// See https://aka.ms/new-console-template for more information


using PublicTransport.Client;

using var httpClient = new HttpClient();
var client = new PublicTransportClient(httpClient)
{
    BaseUrl = "http://localhost:5124/"
};

var transports = await client.PublicTransportAllAsync();

foreach (var t in transports)
{
    Console.WriteLine($"{t.Id}: {t.TransportType}");

    foreach (var sp in t.ServicePlans)
    {
        Console.WriteLine($"    {sp.TimeStamp}: {sp.Id}: {sp.Type} {sp.Description}");
    }
}


Console.WriteLine("\nService Plans:");

var servicePlans = await client.ServicePlanAllAsync();

foreach (var s in servicePlans)
    Console.WriteLine($"{s.Id}: {s.Type}");
