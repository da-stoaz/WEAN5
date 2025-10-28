using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using Microsoft.EntityFrameworkCore;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace PublicTransport.Pages.ServicePlans
{
    public class IndexModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public IndexModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        public IList<ServicePlan> ServicePlan { get;set; } = default!;

        public async Task OnGetAsync()
        {
            var client = _httpClientFactory.CreateClient("PublicTransportApi");
            ServicePlan = await client.GetAsync("api/ServicePlan").Result.Content.ReadFromJsonAsync<List<ServicePlan>>() ?? [];
        }
    }
}
