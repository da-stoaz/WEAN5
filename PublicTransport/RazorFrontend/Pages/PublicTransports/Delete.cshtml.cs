using Microsoft.AspNetCore.Mvc;
using Microsoft.AspNetCore.Mvc.RazorPages;
using PublicTransport.Data;
using PublicTransport.Entities;


namespace RazorFrontend.Pages.PublicTransports
{
    public class DeleteModel : PageModel
    {
        private readonly IHttpClientFactory _httpClientFactory;

        public DeleteModel(IHttpClientFactory httpClientFactory)
        {
            _httpClientFactory = httpClientFactory;
        }

        [BindProperty]
        public PublicTransportE PublicTransport { get; set; } = default!;

        public async Task<IActionResult> OnGetAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }


            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi");
            var response = await httpClient.GetAsync($"api/PublicTransport/{id}");


            var publictransport = await response.Content.ReadFromJsonAsync<PublicTransportE>();

            if (publictransport is not null)
            {
                PublicTransport = publictransport;

                return Page();
            }

            return NotFound();
        }

        public async Task<IActionResult> OnPostAsync(int? id)
        {
            if (id == null)
            {
                return NotFound();
            }


            var httpClient = _httpClientFactory.CreateClient("PublicTransportApi");
            var response = await httpClient.GetAsync($"api/PublicTransport/{id}");


            var publictransport = await response.Content.ReadFromJsonAsync<PublicTransportE>();
            if (publictransport != null)
            {
                
                await httpClient.DeleteAsync($"api/PublicTransport/{id}");
            }

            return RedirectToPage("./Index");
        }
    }
}
