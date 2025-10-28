using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace PublicTransport.Pages.PublicTransports
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
