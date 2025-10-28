using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Entities;


namespace RazorFrontend.Pages.PublicTransports
{
    public class IndexModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public IndexModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public IList<PublicTransportE> PublicTransport { get;set; } = default!;

        public async Task OnGetAsync()
        {
            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi");
            
            PublicTransport = await httpClient.GetFromJsonAsync<List<PublicTransportE>>("api/PublicTransport") ?? [];
        }
    }
}
